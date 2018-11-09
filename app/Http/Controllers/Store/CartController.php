<?php

namespace App\Http\Controllers\Store;
use Cart;
use Response;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;
use App\ProductOther;

class CartController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_id = session()->getId();

        $total = round(Cart::session($session_id)->getTotal(),2);
        $subtotal = round(Cart::session($session_id)->getSubTotal(),2);
        $quantity = Cart::session($session_id)->getTotalQuantity();
        
        $items = [];
        
        Cart::session($session_id)->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        return \View::make('store.pages.cart', array('items' => $items, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity));
    }

    public function addItem($item, $quantity = 1){
        $session_id = session()->getId();

        $product = Product::where('barcode', $item)->first();
        $type = '';
        $itemQuantity = 1;

        if($product){
            $item = $product;
            $type = 'product';
        }else{
            $box = ProductOther::where('barcode', $item)->first();
            
            if($box){
                $item = $box;
                $type = 'product';
            }else{
                $model = Model::where('barcode', $item)->first();

                if($model){
                    $item = $model;
                    $item->price = 0;
                    $type = 'model';
                }
            }

            if($type == 'box'){
                $itemQuantity = $quantity;
            }
        }

        if($item){
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
                    'photo' => asset("uploads/products/" . $item->photos->first()['photo']),
                    'type' => 'product'
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

    public function pay(){
        $provider = new ExpressCheckout;      // To use express checkout.
       // $provider = new AdaptivePayments; 

        $provider = PayPal::setProvider('express_checkout');      // To use express checkout(used by default).
        //$provider = PayPal::setProvider('adaptive_payments');     // To use adaptive payments.

        $provider->setCurrency('EUR')->setExpressCheckout($data);
    }

    public function removeItem($item){
        $session_id = session()->getId();

        $remove = Cart::session($session_id)->remove($item);

        $total = round(Cart::session($session_id)->getTotal(),2);
        $subtotal = round(Cart::session($session_id)->getSubTotal(),2);
        $quantity = Cart::session($session_id)->getTotalQuantity();

        if($remove){
            return Response::json(array('success' => true, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity));
        }
    }

}
