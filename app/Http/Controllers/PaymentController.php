<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Payment;
use App\Selling;
use App\History;
use App\Repair;
use App\Product;
use App\PaymentDiscount;
use App\Partner;
use App\PartnerMaterial;
use App\User;
use App\ProductOther;
use App\Order;
use App\ExchangeMaterial;
use App\MaterialQuantity;
use App\Currency;
use Response;
use Auth;
use Cart;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();
        
        return view('admin.payments.index', compact('payments'));
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
        $payment = new Payment;
        return $payment->store_payment($request);
    }

    public function partner_payment(Request $request)
    {
        $cartConditions = Cart::getConditions();
        $defaultCurrency = Currency::where('default', 'yes')->first();

        foreach($cartConditions as $condition) {
            $attributes = $condition->getAttributes();

            if($attributes['partner'] == 'true'){
                if($attributes['partner_id'] && $attributes['partner_id'] != ''){
                    $user = User::find($attributes['partner_id']);
                    $partner = Partner::where('user_id', $user->id)->first();
                }
            }
        }

        if($partner){
            foreach($request->materials as $material){
                $material = (array)$material;
                $quantity = MaterialQuantity::where([
                    ['material_id', '=', $material['material_id']],
                    ['store_id', '=', Auth::user()->getStore()->id]
                ])->first();

                if(!count($quantity)){
                    $create_quantity = new MaterialQuantity();
                    $create_quantity->store_id = Auth::user()->getStore()->id;
                    $create_quantity->quantity = 0;
                    $create_quantity_material_id = $material['material_id'];
                }
    
                if($material['material_given'] > $material['material_weight']){
                    
                    $quantity->quantity = $quantity->quantity + ($material['material_given']);
                    $quantity->save();
    
                    foreach($partner->materials as $partner_material){
                        if($partner_material->material_id = $material['material_id']){
                            $partner_material->quantity = $partner_material + ($material['material_weight'] - $material['material_given']);
    
                            $partner_material->save();
                        }else{
                            $p_material = new PartnerMaterial();
                            $p_material->material_id = $material['material_id'];
                            $p_material->partner_id = $partner->id;
                            $p_material->quantity = $partner_material + ($material['material_weight'] - $material['material_given']);
    
                            $p_material->save();
                        }
                    }
                } else {
                    $quantity->quantity = $quantity->quantity + ($material['material_given']);
                    $quantity->save();
    
                    foreach($partner->materials as $partner_material){
                        if($partner_material->material_id = $material['material_id']){
                            $partner_material->quantity = $partner_material->quantity - ($material['material_weight'] - $material['material_given']);
    
                            $partner_material->save();
                        }else{
                            $p_material = new PartnerMaterial();
                            $p_material->material_id = $material['material_id'];
                            $p_material->partner_id = $partner->id;
                            $p_material->quantity = $partner_material + ($material['material_weight'] - $material['material_given']);
    
                            $p_material->save();
                        }
                    }
                }
    
                $partner->money = $partner->money + ($request->workmanship['given'] - $request->workmanship['wanted']);
                $partner->save();
    
                $request->request->add(['given_sum' => $request->workmanship['given']]);
                $request->request->add(['pay_currency' => $defaultCurrency->id]);
                $request->request->add(['wanted_sum' => $request->workmanship['wanted']]);
                $request->request->add(['partner_method' => true]);
    
                if($request->pay_method == 'false'){
                    $request->request->add(['method' => 'cash']);
                } else{
                    $request->request->add(['method' => 'post']);
                }
    
                $payment = new Payment;
                return $payment->store_payment($request);
            }
        }
    }

    public function order_materials(Request $request)
    {
        //Getting all products in the cart related with orders
        $allItems = [];
        $boxInList = false;
        $orders = [];

        Cart::session(Auth::user()->getID())->getContent()->each(function($item) use (&$items)
        {
            $allItems[] = $item;
            if($item['attributes']->type == 'product' && $item['attributes']->order != ''){
                $orders[] = $item['attributes']->order;
            } else if ($item['attributes']->type == 'box') {
                $boxInList = true;
            }
        });

        $defaultMaterials = DB::table('materials')
                ->orderBy('id', 'asc')
                ->groupBy('parent_id')
                ->get();

        $orders = array_unique($orders);
        $orders_earnest = [];
        //Get all materials from all products orders
        $materials = array();

        foreach($allItems as $i => $tmpItem){
            $obj = null;
            if($tmpItem['attributes']->type == 'product' && $tmpItem['attributes']->order != '') {
                $obj = Order::find($tmpItem);
            } else if ( $tmpItem['attributes']->type == 'product' && $tmpItem['attributes']->order == '' ) {
                $obj = Product::find($ $tmpItem['attributes']->product_id);
            }

            if($obj && $obj->materials) $materials[] = $order->materials;
        }

        foreach($orders as $i => $order){
            $order = Order::find($order);
            $orders_earnest[$i]['id'] = $order->id;

            if($order->earnest_used == 'no'){
                $orders_earnest[$i]['deposit'] = $order->earnest;
            }

            if($order->materials){
                $responseMaterials = [];
                
                foreach($order->materials as $material) {

                    $materialQuantity = MaterialQuantity::where([
                        ['material_id', '=', $material['material_id']],
                        ['store_id', '=', Auth::user()->getStore()->id]
                    ])->first();

                    foreach($defaultMaterials as $mat) {
                        if($materialQuantity->material->parent->id == $mat->id) {
                            $defMaterial = $mat;
                            break;
                        }
                    }

                    $responseMaterials[] = [
                        'label' => $materialQuantity->material->parent->name.' - '.$materialQuantity->material->code,
                        'sample' => $materialQuantity->material->code,
                        'material-type' => $materialQuantity->material->parent->id,
                        'value' => $materialQuantity->material->id,
                        'weight_equalized' => $materialQuantity->material->code / $defMaterial->code * $order->product->weight,
                        'weight' => $order->product->weight
                    ];
                }

                $orders_earnest[$i]['materials'] = $responseMaterials;
            }
        }

        $pass_materials = [];
        foreach($materials as $material){
            $material = $material[0];
            $order = $material->order;
            $order_items = count($material->order->items);
            $materialQuantity = MaterialQuantity::where([
                ['material_id', '=', $material['material_id']],
                ['store_id', '=', Auth::user()->getStore()->id]
            ])->first();

            $weight = $material->weight;

            $products_weight = 0;
            $count_products = 0;
            foreach($orders as $tmpOrder){
                if($tmpOrder == $material->order_id){
                    $product = Product::where('barcode', $item['attributes']->barcode)->first();

                    if($product->material_id == $materialQuantity->material_id){
                        $count_products++;
                        $products_weight += $item['attributes']->weight;
                    }
                }
            }

            foreach($defaultMaterials as $mat) {
                if($materialQuantity->material->parent->id == $mat->id) {
                    $defMaterial = $mat;
                    break;
                }
            }

            if($order_items == $count_products || $order_items == 1){
                $weight = $material->weight;
            }else{
                if($weight <= $products_weight){
                    $weight = $material->weight;
                }else{
                    $weight = $products_weight;
                }
            }

            if(isset($pass_materials[$materialQuantity->material->parent->id])) {
                $pass_materials[$materialQuantity->material->parent->id]['weight'] += $weight;
            } else {
                $pass_materials[$materialQuantity->material->parent->id] = [
                    'id' => $materialQuantity->material->parent->id,
                    'weight' => $weight + $materialQuantity->material->code / $defMaterial->code * $weight,
                ];
            }
        }

        return Response::json(array('equalization' => $pass_materials, 'orders' => $orders_earnest, 'boxes_in_order' => $boxInList));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payments
     * @return \Illuminate\Http\Response
     */
    public function show(Payments $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payments
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
