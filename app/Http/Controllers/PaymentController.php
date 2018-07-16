<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Sellings;
use App\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Auth;
use Cart;
use App\Repair;
use App\Product;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //Store the selling
        

        //Store the payment
        if($request->given_sum >= $request->wanted_sum){
            //Check if the given sum is more or equal to the wanted sum
            $validator = Validator::make( $request->all(), [
                'wanted_sum' => 'required|numeric|between:0,1000000000',
                'given_sum'  => 'required|numeric|between:0,10000000',
            ]);
    
            if ($validator->fails()) {
                return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
            }

            $payment = new Payment();
            $payment->currency = $request->modal_certificate;
            $payment->method = $request->pay_method;
            $payment->reciept = $request->modal_reciept;
    
            $payment->ticket = $request->modal_ticket;
            $payment->price = $request->wanted_sum;
            $payment->given = $request->given_sum;
            $payment->save();

            $userId = Auth::user()->getId(); 

            
            Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
            {
                if($item['attributes']->type == 'repair'){
                    $repair = Repair::where('barcode', $item->id)->first();

                    if($repair){
                        $repair->status = 'returned';
                        $repair->save();
                    }
                } else if($item['attributes']->type == 'product'){
                    $product = Product::where('barcode', $item->id)->first();
                    if($product){
                        $product->status = 'sold';
                        $product->save();
                    }
                } else if($item['attributes']->type == 'box'){

                }
            });
            
            Cart::clear();
            Cart::clearCartConditions();
            Cart::session($userId)->clear();
            Cart::session($userId)->clearCartConditions();

        }else{
            return Response::json(['errors' => ['more_money' => ['Магазинера трябва да приеме сума равна или по-голяма от дължимата сума.']]], 401);
        }

        //Add to safe   
        //On hold for next sprint

        //Store the notification
        $history = new History();
        
        $history->action = 'payment'; 
        $history->user = Auth::user()->getId();
        $history->table = 'product_payment';
        $history->result_id = $payment->id;

        $history->save();
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
