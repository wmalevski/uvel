<?php

namespace App\Http\Controllers\Store;
use Cart;
use Auth;
use View;
use Session;
use Cookie;
use Response;
use App\Store;
use App\Product;
use App\Model;
use App\Repair;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductOther;
use App\MaterialType;
use App\ProductOtherType;
use \Darryldecode\Cart\CartCondition as CartCondition;
use \Darryldecode\Cart\Helpers\Helpers as Helpers;
use Illuminate\Support\Facades\DB;

Class CartCustomCondition extends CartCondition {
    public function apply($totalOrSubTotalOrPrice, $conditionValue){
        if( $this->valueIsPercentage($conditionValue) )
        {
            if( $this->valueIsToBeSubtracted($conditionValue) )
            {
                $price = $totalOrSubTotalOrPrice;
                if($this->getTarget() == 'subtotal'){
                    $price = \Cart::getSubTotal();
                }elseif($this->getTarget() == 'total'){
                    $price = \Cart::getTotal();
                }
                
                $value = Helpers::normalizePrice( $this->cleanValue($conditionValue) );
                $this->parsedRawValue = $price * ($value / 100);
                $result = floatval($totalOrSubTotalOrPrice - $this->parsedRawValue);
            }
            else if ( $this->valueIsToBeAdded($conditionValue) )
            {
                $value = Helpers::normalizePrice( $this->cleanValue($conditionValue) );

                $this->parsedRawValue = $totalOrSubTotalOrPrice * ($value / 100);

                $result = floatval($totalOrSubTotalOrPrice + $this->parsedRawValue);
            }
            else
            {
                $value = Helpers::normalizePrice($conditionValue);

                $this->parsedRawValue = $totalOrSubTotalOrPrice * ($value / 100);

                $result = floatval($totalOrSubTotalOrPrice + $this->parsedRawValue);
            }
        }

        // if the value has no percent sign on it, the operation will not be a percentage
        // next is we will check if it has a minus/plus sign so then we can just deduct it to total/subtotal/price
        else
        {
            if( $this->valueIsToBeSubtracted($conditionValue) )
            {
                $this->parsedRawValue = Helpers::normalizePrice( $this->cleanValue($conditionValue) );

                $result = floatval($totalOrSubTotalOrPrice - $this->parsedRawValue);
            }
            else if ( $this->valueIsToBeAdded($conditionValue) )
            {
                $this->parsedRawValue = Helpers::normalizePrice( $this->cleanValue($conditionValue) );

                $result = floatval($totalOrSubTotalOrPrice + $this->parsedRawValue);
            }
            else
            {
                $this->parsedRawValue = Helpers::normalizePrice($conditionValue);

                $result = floatval($totalOrSubTotalOrPrice + $this->parsedRawValue);
            }
        }

        // Do not allow items with negative prices.
        return $result < 0 ? 0.00 : $result;
    }

    public function getCalculatedValue($totalOrSubTotalOrPrice)
    {
        $this->apply($totalOrSubTotalOrPrice, $this->getValue());

        return $this->parsedRawValue;
    }
}

class CartController extends BaseController
{
    /**
     * @var ExpressCheckout
     */
    public function __construct()
    {
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $session_id = Auth::user()->getId();
        } else {
            $session_id = Session::getId();
        }

        setcookie('cookie_name', $session_id, time()+(180*30));
        setcookie('cookie_name_time', true, time()+(120*30));

        $total = round(Cart::session($session_id)->getTotal(), 2);
        $subtotal = round(Cart::session($session_id)->getSubTotal(), 2);
        $quantity = Cart::session($session_id)->getTotalQuantity();
        $materialTypes = MaterialType::all();
        $cartConditions = Cart::session($session_id)->getConditions();
        $productothertypes = ProductOtherType::all();
        $stores = Store::where([
            ['id', '!=', 1]
        ])->get();

        if (Auth::check()) {
            $countitems = Cart::session($session_id)->getTotalQuantity();

        } else {
            $countitems = 0;
        }

        $items = [];

        Cart::session($session_id)->getContent()->each(function ($item) use (&$items) {
            $items[] = $item;
        });

        if (!Auth::check()) {
            if ($items) {
                $items = json_encode($items);
                Cookie::queue(cookie('cart_products', $items, $minute = 10));
                $session_id = json_encode($session_id);
                Cookie::queue(cookie('guest_session_id', $session_id, $minute = 10));
                $items = json_decode($items);
            }
        } else {
            $guestItems = json_decode(request()->cookie('cart_products'));
            if ($guestItems) {
                foreach ($guestItems as $guestItem) {
                    if ($items) {
                        foreach ($items as $item) {
                            if ($item->id == $guestItem->id) {
                                $this->updateItem($guestItem->id, $guestItem->quantity);
                            } else {
                                $this->addItem($guestItem->id, $guestItem->quantity);
                            }
                        }
                    } else {
                        $this->addItem($guestItem->id, $guestItem->quantity);
                    }
                }
            }

            if (request()->cookie('guest_session_id')) {
                DB::table('cart_storage')->where('id', json_decode(request()->cookie('guest_session_id')))->delete();
                Cookie::queue(Cookie::forget('guest_session_id'));
            }
            Cookie::queue(Cookie::forget('cart_products'));
        }

        return \View::make('store.pages.cart', array('items' => $items, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity, 'materialTypes' => $materialTypes, 'productothertypes' => $productothertypes, 'stores' => $stores, 'countitems' => $countitems, 'conditions' => $cartConditions));
    }

    public function addItem($item, $quantity = 1)
    {
        $checkNegativeQuantity = ($quantity > 0)? true : false;
        if ($checkNegativeQuantity) {
            if (Auth::check()) {
                $session_id = Auth::user()->getId();
            } else {
                $session_id = Session::getId();
            }

            if (!empty(request()->cookie('cart_products')) && Auth::check()) {
                $product = Product::where([
                    ['barcode', '=', $item]
                ])->first();
            } else {
                $product = Product::where([
                    ['barcode', '=', $item],
                    ['status', '=', 'available']
                ])->first();
            }

            $type = '';
            $itemQuantity = 1;

            if ($product) {
                $item = $product;
                $type = 'product';

                $product->status = 'selling';
                $product->save();
            } else {
                $box = ProductOther::where([
                    ['barcode', '=', $item],
                    ['quantity', '>=', $quantity]
                ])->first();

                if ($box) {
                    $box->quantity = $box->quantity - $quantity;
                    $box->save();

                    $item = $box;
                    $type = 'box';
                }

                if ($type == 'box') {
                    $itemQuantity = $quantity;
                }
            }

            if ($type != '') {
                Cart::session($session_id)->add(array(
                    'id' => $item->barcode,
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $itemQuantity,
                    'attributes' => array(
                        'weight' => $item->weight,
                        'price' => $item->price,
                        'name' => $item->name,
                        'product_id' => $item->id,
                        'type' => $type
                    )
                ));

                $total = round(Cart::session($session_id)->getTotal(), 2);
                $subtotal = round(Cart::session($session_id)->getSubTotal(), 2);
                $quantity = Cart::session($session_id)->getTotalQuantity();

                return Response::json(array('success' => true, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity, 'message' => 'Продукта беше успешно добавен в количката!'));
            } else {
                return Response::json(array('success' => false, 'error' => 'Продукта не е намерен или е извън наличност!'));
            }
        } else {
            return Response::json(array('success' => false, 'error' => 'Желаното от Вас количество не е въведено коректно!'));
        }
    }


    public function removeItem($item){
        if (Auth::check()) {
            $session_id  = Auth::user()->getId();
        } else {
            $session_id  = Session::getId();
        }

        $items = [];
        
        Cart::session($session_id)->getContent()->each(function($singleitem) use (&$items)
        {
            $items[] = $singleitem;
        });

        $table = '';
        foreach($items as $singleitem){
            $table .= View::make('admin/selling/table',array('item'=>$singleitem))->render();

            
            $product = Product::where('barcode', $singleitem->id)->first();
            $product_box = ProductOther::where('barcode', $singleitem->id)->first();
            $repair = Repair::where('barcode', $singleitem->id)->first();
            
            if($product){
                $product->status = 'available';
                $product->save();
            }else if($product_box){
                if($singleitem->id == $item){
                    $currentProductOtherItem = ProductOther::where('barcode', $item)->first();
                    $currentProductOtherItem->quantity = $currentProductOtherItem->quantity + $singleitem->quantity;
                    $currentProductOtherItem->save();
                }

                $product_box->save();
            }
        }

        $remove = Cart::session($session_id)->remove($item);
        
        $total = round(Cart::session($session_id)->getTotal(),2);
        $subtotal = round(Cart::session($session_id)->getSubTotal(),2);
        $quantity = Cart::session($session_id)->getTotalQuantity();

        $dds = round($subtotal - ($subtotal/1.2), 2);

        if($remove){
            return Response::json(array('success' => true, 'table' => $table, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity, 'dds' => $dds));  
        }
    }

    public function updateItem($item, $quantity)
    {
        if (Auth::check()) {
            $session_id = Auth::user()->getId();
        } else {
            $session_id = Session::getId();
        }

        if ($quantity > 0) {
            Cart::session($session_id)->update($item, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity
                ),
            ));

            $box = ProductOther::where([
                ['barcode', '=', $item],
                ['quantity', '>=', $quantity]
            ])->first();

            if ($box) {
                $item = Cart::session($session_id)->get($item);

                $price = $item->price;
                $priceWithQuantity = $item->price * $item->quantity;
                $total = round(Cart::session($session_id)->getTotal(), 2);
            }

            return Response::json(array('success' => true, 'itemID' => $item->id, 'total' => $total, 'price' => $price, 'quantity' => $quantity, 'priceWithQuantity' => $priceWithQuantity));
        }
    }
}
