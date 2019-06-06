<?php

namespace App\Http\Controllers\Store;
use Cart;
use Auth;
use View;
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
        $session_id = Auth::user()->getId();
        
        $total = round(Cart::session($session_id)->getTotal(),2);
        $subtotal = round(Cart::session($session_id)->getSubTotal(),2);
        $quantity = Cart::session($session_id)->getTotalQuantity();
        $materialTypes = MaterialType::all();
        $cartConditions = Cart::session($session_id)->getConditions();
        $productothertypes = ProductOtherType::all();
        $stores = Store::where([
            ['id' , '!=', 1]
        ])->get();

        if(Auth::check()){
            $countitems = Cart::session($session_id)->getTotalQuantity();
      
          }else{
              $countitems = 0;
          }
        
        $items = [];
        
        Cart::session($session_id)->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        return \View::make('store.pages.cart', array('items' => $items, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity, 'materialTypes' => $materialTypes, 'productothertypes' => $productothertypes, 'stores' => $stores, 'countitems' => $countitems, 'conditions' => $cartConditions));
    }

    public function addItem($item, $quantity = 1){
        $session_id = Auth::user()->getId();

        $product = Product::where([
            ['barcode', '=', $item],
            ['status', '=', 'available']
        ])->first();
        $type = '';
        $itemQuantity = 1;

        if($product){
            $item = $product;
            $type = 'product';

            $product->status = 'selling';
            $product->save();
        }else{
            $box = ProductOther::where([
                ['barcode', '=', $item],
                ['quantity', '>=', $quantity]
            ])->first();
            
            if($box){
                $currentProductOtherQuantity = ProductOther::where('barcode', $item)->first()->quantity;
                if ($currentProductOtherQuantity) {
                    ProductOther::where('barcode', $item)->update(['quantity' => ($currentProductOtherQuantity - $quantity)]);
                }
                $item = $box;
                $type = 'box';
            }

            if($type == 'box'){
                $itemQuantity = $quantity;
            }
        }

        if($type != ''){
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

            $total = round(Cart::session($session_id)->getTotal(),2);
            $subtotal = round(Cart::session($session_id)->getSubTotal(),2);
            $quantity = Cart::session($session_id)->getTotalQuantity();

            return Response::json(array('success' => true, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity, 'message' => 'Продукта беше успешно добавен в количката!'));
        }else{
            return Response::json(array('success' => false, 'error' => 'Продукта не е намерен или е извън наличност!'));
        }
    }


    public function removeItem($item){
        $userId = Auth::user()->getId(); 
        //dd($item);

        $items = [];
        
        Cart::session($userId)->getContent()->each(function($singleitem) use (&$items)
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
                //$product_box->quantity = $product_box->quantity+$singleitem->quantity;
                $product_box->save();
            }
        }

        $remove = Cart::session($userId)->remove($item);
        
        $total = round(Cart::session($userId)->getTotal(),2);
        $subtotal = round(Cart::session($userId)->getSubTotal(),2);
        $quantity = Cart::session($userId)->getTotalQuantity();

        $dds = round($subtotal - ($subtotal/1.2), 2);

        if($remove){
            return Response::json(array('success' => true, 'table' => $table, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity, 'dds' => $dds));  
        }
    }

    public function updateItem($item, $quantity){
        $userId = Auth::user()->getId(); 
        
        if($quantity > 0){
            Cart::session($userId)->update($item, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity
                ),
            ));

            $item = Cart::session($userId)->get($item);

            $price = $item->price;
            $priceWithQuantity = $item->price*$item->quantity;
            $total = round(Cart::session($userId)->getTotal(),2);

            return Response::json(array('success' => true, 'itemID' => $item->id, 'total' => $total, 'price' => $price, 'quantity' => $quantity, 'priceWithQuantity' => $priceWithQuantity));
        }
    }

   

}
