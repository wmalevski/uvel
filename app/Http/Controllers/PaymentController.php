<?php

namespace App\Http\Controllers;

use App\Price;
use App\Store;
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

class PaymentController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $payments = Payment::orderBy('created_at','DESC');

        if(Auth::user()->role !== 'admin'){
            $payments = $payments->where('receipt', 'yes');
        }

        $payments = $payments->get();

        return view('admin.payments.index', compact('payments'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
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

        Cart::session(Auth::user()->getID())->getContent()->each(function($item) use (&$allItems)
        {
            if ($item['attributes']->type == 'box') {
                $boxInList = true;
            }

            $allItems[] = $item;
        });

        $defaultMaterials = DB::table('materials')
                ->orderBy('id', 'asc')
                ->groupBy('parent_id')
                ->get();

        //Get all materials from all products orders
        $materials = [];

        foreach($allItems as $i => $tmpItem){
            $obj = null;
            $order_id = null;
            $product_id = null;
            if($tmpItem['attributes']->type == 'product' && $tmpItem['attributes']->order != '') {
                $orders[] = $tmpItem['attributes']->order;
                $obj = Order::find($tmpItem['attributes']->order);
                $order_id = $tmpItem['attributes']->order;
                $product_id = $obj->product_id;

            } else if ( $tmpItem['attributes']->type == 'product' && $tmpItem['attributes']->order == '' ) {
                $obj = Product::find($tmpItem['attributes']->product_id);
            }

            if($obj && $obj->material_id) {
                $materials[] = [
                    'material_id' => $obj->material_id,
                    'weight' => $obj->weight,
                    'order_id' => $order_id,
                    'product_id' => $product_id,

                    //material info:
                    'code' => $obj->material->code,
                    'parent_id' => $obj->material->parent->id,

                    'exchange_materials' => $obj->materials ? $obj->materials : false
                ];
            }
        }

        $orders = array_unique($orders);
        $orders_earnest = [];

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

                    foreach($defaultMaterials as $mat) {
                        if($material->material->parent_id == $mat->id) {
                            $defMaterialExchange = $mat;
                            break;
                        }
                    }

                    $responseMaterials[] = [
                        'label' => $materialQuantity->material->parent->name.' - '.$materialQuantity->material->code,
                        'sample' => $materialQuantity->material->code,
                        'material-type' => $materialQuantity->material->parent->id,
                        'value' => $materialQuantity->material->id,
                        'weight_equalized' => $materialQuantity->material->code / $defMaterial->code * $order->product->weight,
                        'weight' => $order->product->weight,
                        'weight_exchange' => $material['weight'],
                        'exchange_weight_eq' => $material->material->code / $defMaterialExchange->code * $material['weight']
                    ];
                }

                $orders_earnest[$i]['materials'] = $responseMaterials;
            }
        }

        $pass_materials = [];
        foreach($materials as $material) {

            foreach($defaultMaterials as $mat) {
                if($material['parent_id'] == $mat->id) {
                    $defMaterial = $mat;
                    break;
                }
            }

            $weight = $material['weight'];

            if(isset($pass_materials[$material['parent_id']])) {
                $pass_materials[$material['parent_id']]['weight'] += $material['code'] / $defMaterial->code * $weight;
            } else {
                $pass_materials[$material['parent_id']] = [
                    'id' => $material['parent_id'],
                    'weight' => $material['code'] / $defMaterial->code * $weight
                ];
            }
        }

        return Response::json(array('equalization' => $pass_materials, 'orders' => $orders_earnest, 'boxes_in_order' => $boxInList));
    }
     public function generateExchangeAcquittance($id)
     {
         $payment = Payment::find($id);
         $store = Store::where('id', $payment->store_id)->first();
         $currency = Currency::find($payment->currency_id);
         $exchangeMaterials = $payment->exchange_materials;
         $materials = [];

         foreach ($exchangeMaterials as $exchangeMaterial) {
             $materials[] = array(
                 "name" => $exchangeMaterial->material->name . ' - ' . $exchangeMaterial->material->color . ' - ' . $exchangeMaterial->material->code,
                 "carat" => $exchangeMaterial->material->carat,
                 "price_per_weight" => Price::where(['id' => $exchangeMaterial->material_price_id])->first()->price,
                 "weight" => $exchangeMaterial->weight
             );
         }

         if ($payment) {
             $mpdf = new \Mpdf\Mpdf([
                 'mode' => 'utf-8',
                 'format' => [148, 210]
             ]);

             $html = view('pdf.exchange_acquittance', compact('payment', 'store', 'materials', 'currency'))->render();
             $mpdf->WriteHTML($html);
             $mpdf->Output(str_replace(' ', '_', $payment->id) . '_exchange_material.pdf', \Mpdf\Output\Destination::DOWNLOAD);
         }

         abort(404, 'Product not found.');
     }
}
