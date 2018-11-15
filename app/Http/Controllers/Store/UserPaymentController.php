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
        $user_info = [
            'user_id' => Auth::user()->getId(),
            'shipping_method' => $request->shipping_method,
            'payment_method' => $request->payment_method,
            'information' => $request->information,
            'payment_id' => $payment->id,
            'store_id' => $request->store_id,
            'еkont_address' => $requet->ekont_address
        ];

        Session::push('cart_info', $user_info);

        if($request->payment_method == 'on_delivery'){
            $payment = new UserPayment();
            return $payment->storePayment();
            
        } else if ($request->payment_method == 'paypal'){
            $pay = new PaypalPay();
            return $pay->payWithpaypal($request);
        } else if ($request->payment_method == 'borika'){
            
        }
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
