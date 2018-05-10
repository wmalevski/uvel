<?php

namespace App\Http\Controllers;

use App\Sellings;
use Illuminate\Http\Request;
use App\Repair_types;
use Cart;
use App\Products;
use App\Products_others;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\JsonResponse;
use App\Discount_codes;
use Response;

class SellingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repairTypes = Repair_types::all();
        $discounts = Discount_codes::all();
        $cartConditions = Cart::session(Auth::user()->getId())->getConditions();

        $items = [];
        
        Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });
        
        return \View::make('admin/selling/index', array('repairTypes' => $repairTypes, 'items' => $items, 'discounts' => $discounts, 'conditions' => $cartConditions));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sellings  $sellings
     * @return \Illuminate\Http\Response
     */
    public function show(Sellings $sellings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sellings  $sellings
     * @return \Illuminate\Http\Response
     */
    public function edit(Sellings $sellings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sellings  $sellings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sellings $sellings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sellings  $sellings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sellings $sellings)
    {
        //
    }

    public function sell(Request $request){
        if($request->amount_check == false){
            if($request->barcode){
                $item = Products::where('barcode', $request->barcode)->first();
            } else if($request->catalog_number){
                $item = Products::where('code', $request->catalog_number)->first();
            }
        }else{
            if($request->barcode){
                $item = Products_others::where('barcode', $request->barcode)->first();
            } else if($request->catalog_number){
                $item = Products_others::where('code', $request->catalog_number)->first();
            }
        }

        if($item){            
            $userId = Auth::user()->getId(); // or any string represents user identifier
            
            $find = Cart::session($userId)->get($item->barcode);

            if($find && $request->amount_check == false) {
                
            }else{
                Cart::session($userId)->add(array(
                    'id' => $item->barcode,
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $request->quantity,
                    'attributes' => array(
                        'weight' => $item->weight
                    )
                ));
            }
            
            // $row = Cart::add(['id' => $request->barcode, 'name' => $item->name, 'qty' => $request->quantity, 'price' => 9.99, 'options' => ['weight' => $item->weight]]);

            // $cart = Cart::restore(Auth::user()->getId());


            // if(!$cart){
            //     Cart::store(Auth::user()->getId());
            // }

            $tax = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'ДДС',
                'type' => 'tax',
                'target' => 'subtotal',
                'value' => '+20%',
                'attributes' => array(
                    'description' => 'Value added tax',
                    'more_data' => 'more data here'
                )
            ));

            Cart::condition($tax);
            Cart::session($userId)->condition($tax);

            $total = Cart::session($userId)->getTotal();
            $subtotal = Cart::session($userId)->getSubTotal();
            $quantity = Cart::session($userId)->getTotalQuantity();

            $items = [];
            
            Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
            {
                $items[] = $item;
            });

            $table = '';
            foreach($items as $item){
                $table .= View::make('admin/selling/table',array('item'=>$item))->render();
            }

            return Response::json(array('success' => true, 'table' => $table, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity));  

        }else{
            return Response::json(array('success' => false)); 
        }
    }

    public function getCartTable(){
        $userId = Auth::user()->getId(); // or any string represents user identifier

        $total = Cart::session($userId)->getTotal();
        $subtotal = Cart::session($userId)->getSubTotal();
        $quantity = Cart::session($userId)->getTotalQuantity();

        $items = [];
        
        Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        $table = '';
        foreach($items as $item){
            $table .= View::make('admin/selling/table',array('item'=>$item))->render();
        }

        return Response::json(array('success' => true, 'table' => $table, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity));  
    }

    public function clearCart(){
        $userId = Auth::user()->getId(); 

        Cart::clear();
        Cart::clearCartConditions();
        Cart::session($userId)->clear();
        Cart::session($userId)->clearCartConditions();

        return redirect()->route('admin');
    }

    public function setDiscount(Request $request, $barcode){
        
        $userId = Auth::user()->getId(); 

        $discount = new Discount_codes;
        $result = json_encode($discount->check($barcode));

        if($result == 'true'){
            $card = Discount_codes::where('barcode', $barcode)->first();

            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'Отстъпка',
                'type' => 'discount',
                'target' => 'subtotal',
                'value' => '-'.$card->discount.'%',
                'attributes' => array(
                    'description' => 'Value added tax',
                    'more_data' => 'more data here'
                )
            ));

            Cart::condition($condition);
            Cart::session($userId)->condition($condition);

            $total = Cart::session($userId)->getTotal();
            $subtotal = Cart::session($userId)->getSubTotal();

            return Response::json(array('total' => $total, 'subtotal' => $subtotal));  
        } 
    }

    public function removeItem(Request $request, $item){
        $userId = Auth::user()->getId(); 
        $remove = Cart::session($userId)->remove($item);

        $total = Cart::session($userId)->getTotal();
        $subtotal = Cart::session($userId)->getSubTotal();
        $quantity = Cart::session($userId)->getTotalQuantity();

        $items = [];
        
        Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        $table = '';
        foreach($items as $item){
            $table .= View::make('admin/selling/table',array('item'=>$item))->render();
        }

        if($remove){
            return Response::json(array('success' => true, 'table' => $table, 'total' => $total, 'subtotal' => $subtotal, 'quantity' => $quantity));  
        }
    }

    public function printInfo(){
        //$repair = Repairs::find($id);

        $userId = Auth::user()->getId(); 
        $total = Cart::session($userId)->getTotal();
        $subtotal = Cart::session($userId)->getSubTotal();

        $items = [];
        
        Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        $table = '';
        foreach($items as $item){
            $table .= View::make('admin/selling/table',array('item'=>$item))->render();
        }

        return Response::json(array('success' => 'yes', 'html' => View::make('admin/selling/information',array('items'=>$items, 'total' => $subtotal, 'subtotal' => $subtotal))->render()));
    }
}
