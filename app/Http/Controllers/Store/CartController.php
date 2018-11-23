<?php

namespace App\Http\Controllers\Store;
use Cart;
use Auth;
use Response;
use App\Store;
use App\Product;
use App\Model;
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

        return \View::make('store.pages.cart', array('items' => $items, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity, 'materialTypes' => $materialTypes, 'productothertypes' => $productothertypes, 'stores' => $stores, 'countitems' => $countitems));
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

            $product->status = 'reserved';
            $product->save();
        }else{
            $box = ProductOther::where([
                ['barcode', '=', $item],
                ['quantity', '>=', $quantity]
            ])->first();
            
            if($box){
                // $box->quantity = $box->quantity-$quantity;
                // $box->save();
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

            return Response::json(array('success' => true, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity));
        }else{
            return Response::json(array('success' => true, 'not_found' => 'The item is not found'));
        }
    }

   

}
