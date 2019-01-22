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
use Response;
use Auth;
use Cart;
use App\ExchangeMaterial;
use App\MaterialQuantity;

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


        // $materials = [(object)[
        //     'material_id' => 1,
        //     'material_weight' => 500,
        //     'material_given' => 0,
        // ]];
        
        // $materials = (array)$materials;

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
                        $partner_material->quantity = $partner_material - ($material['material_weight'] - $material['material_given']);

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
