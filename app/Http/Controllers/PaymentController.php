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
use Response;
use Auth;
use Cart;

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

        foreach($cartConditions as $condition) {
            $attributes = $condition->getAttributes();

            if($attributes['partner'] == 'true'){
                if($attributes['partner_id'] && $attributes['partner_id'] != ''){
                    $user = User::find($attributes['partner_id']);
                    $partner = Partner::where('user_id', $user->id)->first();
                }
            }
        }

        foreach($request->materials as $material){
            $material = (array)$material;
            $quantity = MaterialQuantity::find($material['material_id']);

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
            $request->request->add(['pay_currency' => 1]);
            $request->request->add(['wanted_sum' => $request->workmanship['wanted']]);
            $request->request->add(['partner_method' => true]);

            //TODO
            //Just save the given money in the save and update partners money balance.

            $payment = new Payment;
            return $payment->store_payment($request);
        }
    }

    public function order_materials(Request $request)
    {
        //Getting all products in the cart related with orders
        $items = [];
        
        Cart::session(Auth::user()->getID())->getContent()->each(function($item) use (&$items)
        {
            if($item['attributes']->type == 'product' && $item['attributes']->order != ''){
                $items[] = $item;
            }
        });

        $orders = array();
        foreach($items as $item){
            $orders[] = $item['attributes']->order;
        }

        $orders = array_unique($orders);

        //Get all materials from all products orders
        $materials = array();
        foreach($orders as $order){
            $order = Order::find($order);

            if($order->materials){
                $materials[] = $order->materials;
            }
        }

        //Passing the given materials to the FE for showing them in the modal
        $pass_materials = array();
        foreach($materials as $material){
            $material = $material[0];
            $order = $material->order;
            $order_items = count($material->order->items);
            $parent = MaterialQuantity::find($material->material_id);

            $weight = $material->weight;

            $products_weight = 0;
            $count_products = 0;
            foreach($items as $item){
                if($item['attributes']->order == $material->order_id){
                    $product = Product::where('barcode', $item->id)->first();

                    if($product->material_id == $parent->id){
                        $count_products++;
                        $products_weight += $item['attributes']->weight;
                    }
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

            $pass_materials[] = [
                'label' => $parent->material->parent->name.' - '.$parent->material->color.' - '.$parent->material->carat,
                'value' => $parent->id,
                'price' => $parent->material->pricesBuy->first()->price,
                'for_buy'  => $parent->material->for_buy,
                'for_exchange' => $parent->material->for_exchange,
                'carat_transform' => $parent->material->carat_transform,
                'carat' => $parent->material->carat,
                'order_id' => $material->order_id,
                'weight' => $weight
            ];
        }

        return Response::json(array('materials' => $pass_materials));
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
