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
        
        $items = [];
        
        Cart::session($session_id)->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        return \View::make('store.pages.cart', array('items' => $items, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity, 'materialTypes' => $materialTypes, 'productothertypes' => $productothertypes, 'stores' => $stores));
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

   

}
