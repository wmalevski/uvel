<?php

namespace App\Http\Controllers;

use App\Sellings;
use Illuminate\Http\Request;
use App\RepairType;
use Cart;
use App\Products;
use App\Products_others;
use App\Repair;
use Auth;
use App\Currency;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\JsonResponse;
use App\DiscountCodes;
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
        $repairTypes = RepairType::all();
        $discounts = DiscountCodes::all();
        $currencies = Currency::all();
        $subTotal = Cart::session(Auth::user()->getId())->getSubTotal();
        $cartConditions = Cart::session(Auth::user()->getId())->getConditions();
        $condition = Cart::getCondition('Discount');
        if($condition){
            $priceCon = $condition->getCalculatedValue($subTotal);
        } else{
            $priceCon = 0;
        }
        $items = [];

        //dd($subTotal);
        
        Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });
        
        return \View::make('admin/selling/index', array('priceCon' => $priceCon, 'repairTypes' => $repairTypes, 'items' => $items, 'discounts' => $discounts, 'conditions' => $cartConditions, 'currencies' => $currencies));
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
        $type = "product";

        $tax = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'ДДС',
            'type' => 'tax',
            'target' => 'subtotal',
            'value' => '+20%',
            'attributes' => array(
                'description' => 'Value added tax',
                'more_data' => 'more data here'
            ),
            'order' => 2
        ));

        Cart::condition($tax);
        Cart::session(Auth::user()->getId())->condition($tax);

        if($request->amount_check == false){
            if($request->type_repair == true){
                $item = Repair::where(
                    [
                        ['barcode', '=', $request->barcode],
                        ['status', '=', 'done']
                    ]       
                )->first();
                $type = "repair";
            }else{
                if($request->barcode){
                    $item = Products::where('barcode', $request->barcode)->first();
                } else if($request->catalog_number){
                    $item = Products::where('code', $request->catalog_number)->first();
                }
            }

            if($item){
                if($item->status == 'selling'){
                    return Response::json(['errors' => array(
                        'selling' => 'Продукта вмомента принадлежи на друга продажба.'
                    )], 401);
                }
    
                if($type == "product"){
                    $item->status = 'selling';
                    $item->save();
                }
            }
        }else{
            if($request->barcode){
                $item = Products_others::where('barcode', $request->barcode)->first();
            } else if($request->catalog_number){
                $item = Products_others::where('code', $request->catalog_number)->first();
            }

            if($item->quantity < $request->quantity){
                return Response::json(['errors' => array(
                    'quantity' => 'Системата няма това количество, което желаете да продадете.'
                )], 401);
            }

            $item->quantity = $item->quantity-$request->quantity;
            $item->save();
        }

        if($item){       
            $userId = Auth::user()->getId(); // or any string represents user identifier
            
            $find = Cart::session($userId)->get($item->barcode);

            if($find && $request->amount_check == false) {
                
            }else{
                if($item->status == 'sold'){
                    $item->price = 0;
                }

                if($type == "repair"){
                    Cart::session($userId)->add(array(
                        'id' => $item->barcode,
                        'name' => 'Връщане на ремонт - '.$item->customer_name,
                        'price' => $item->price,
                        'quantity' => 1,
                        'attributes' => array(
                            'weight' => $item->weight,
                            'type' => 'repair'
                        )
                    ));
            
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
            }

        

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

        
        
        Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
        {
            $product = Products::where('barcode', $item->id)->first();

            if($product){
                $product->status = 'available';
                $product->save();
            }else{
                $product = Products_others::where('barcode', $item->id)->first();

                if($product){
                    $product->quantity = $product->quantity+$item->quantity;
                    $product->save();
                }
            }
        });

        Cart::clear();
        Cart::clearCartConditions();
        Cart::session($userId)->clear();
        Cart::session($userId)->clearCartConditions();

        return redirect()->route('admin');
    }

    public function setDiscount(Request $request, $barcode){
        
        $userId = Auth::user()->getId(); 

        if(strlen($barcode) == 13){
            $discount = new DiscountCodes;
            $result = json_encode($discount->check($barcode));

            if($result == 'true'){
                $card = DiscountCodes::where('barcode', $barcode)->first();
                $setDiscount = $card->discount;
            }
        }else{
            $result = false;
            $setDiscount = $barcode;
        }
        

        if(isset($setDiscount)){
            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'Discount',
                'type' => 'discount',
                'target' => 'subtotal',
                'value' => '-'.$setDiscount.'%',
                'attributes' => array(
                    'description' => 'Value added tax',
                    'more_data' => 'more data here'
                ),
                'order' => 1
            ));

            Cart::condition($condition);
            Cart::session($userId)->condition($condition);

            $total = Cart::session($userId)->getTotal();
            $subtotal = Cart::session($userId)->getSubTotal();

            return Response::json(array('success' => true, 'total' => $total, 'subtotal' => $subtotal));  
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
