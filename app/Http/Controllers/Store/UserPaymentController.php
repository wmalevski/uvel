<?php

namespace App\Http\Controllers\Store;

use App\UserPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\PaypalPay;
use App\Model;
use App\ProductOther;
use App\Product;
use App\UserPaymentProduct;
use Auth;
use Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class UserPaymentController extends Controller
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
        if($request->amount > 0){
            session()->forget('cart_info');

            $restrictions = [
                'shipping_method' => 'required',
                'payment_method' => 'required'
            ];

            if ($request->shipping_method == 'ekont') {
                $restrictions['city'] = 'required';
                $restrictions['street'] = 'required';
                $restrictions['street_number'] = 'required';
                $restrictions['postcode'] = 'required';
                $restrictions['phone'] = 'required';
            } elseif ($request->shipping_method == 'store') {
                $restrictions['store_id'] = 'required';
            }

            $validator = Validator::make($request->all(), $restrictions);

            $user_info = [
                'user_id' => Auth::user()->getId(),
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
                'information' => $request->information,
                'store_id' => $request->store_id,
                'shipping_address' => $request->city.', '.$request->postcode.', '.$request->street.', '.$request->street_number
            ];
    
            Session::push('cart_info', $user_info);

            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }

    
            if($request->payment_method == 'on_delivery'){
                $payment = new UserPayment();
                return $payment->storePayment();
    
            } else if ($request->payment_method == 'paypal'){
                $pay = new PaypalPay();
                return $pay->payWithpaypal($request);
            } else if ($request->payment_method == 'borika'){
                
            }

        }

        return Redirect::to('online');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserPayment  $userPayment
     * @return \Illuminate\Http\Response
     */
    public function show(UserPayment $userPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserPayment  $userPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPayment $userPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserPayment  $userPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPayment $userPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserPayment  $userPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPayment $userPayment)
    {
        //
    }
}
