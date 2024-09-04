<?php

namespace App\Http\Controllers\Store;

use App\UserPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\PayPalPay;
use App\Model;
use App\Store;
use App\ProductOther;
use App\Product;
use App\UserPaymentProduct;
use Auth;
use Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Mail;
use Illuminate\Support\Facades\Log;

class UserPaymentController extends Controller{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        if($request->amount > 0){
            session()->forget('cart_info');

            $restrictions = array(
                'shipping_method' => 'required',
                'payment_method' => 'required'
            );

            $shipping = array('city','street','street_number','postcode','phone');

            switch($request->shipping_method){
                case 'office_address':
                    $restrictions['courier_city'] = 'required';
                    $restrictions['courier_street'] = 'required';
                    $restrictions['courier_street_number'] = 'required';
                    $restrictions['courier_postcode'] = 'required';
                    $restrictions['courier_phone'] = 'required';
                    $shipping['city'] = $request->courier_city;
                    $shipping['street'] = $request->courier_street;
                    $shipping['street_number'] = $request->courier_street_number;
                    $shipping['postcode'] = $request->courier_postcode;
                    $shipping['phone'] = $request->courier_phone;
                    $shipping_address = $shipping['city'].', '.$shipping['postcode'].', '.$shipping['street'].', '.$shipping['street_number'];
                    break;
                case 'home_address':
                    $restrictions['city'] = 'required';
                    $restrictions['street'] = 'required';
                    $restrictions['street_number'] = 'required';
                    $restrictions['postcode'] = 'required';
                    $restrictions['phone'] = 'required';
                    $shipping['city'] = $request->city;
                    $shipping['street'] = $request->street;
                    $shipping['street_number'] = $request->street_number;
                    $shipping['postcode'] = $request->postcode;
                    $shipping['phone'] = $request->phone;
                    $shipping_address = $shipping['city'].', '.$shipping['postcode'].', '.$shipping['street'].', '.$shipping['street_number'];
                    break;
                case 'store':
                    $restrictions['store_id'] = 'required';
                    $shipping_address=null;
                    break;
            }

            $validator = Validator::make($request->all(), $restrictions);

            $member = Auth::user();
            $memberId = $member->getId();
            $user_info = array(
                'user_id' => $memberId,
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
                'information' => $request->information,
                'store_id' => $request->store_id,
                'shipping_address' => $shipping_address
            );

            $storeMeta = [];
            if ($request->has('store_id')) {
                $store = Store::find($request->has('store_id'));
                $storeMeta['name'] = $store->name;
                $storeMeta['location'] = $store->location;
            }

            Session::push('cart_info', $user_info);

            if($validator->fails()){
                return Redirect::back()->withErrors($validator);
            }

            // SEND INTERNAL MAIL
            $cartItems = json_decode($request->cart_items, true);
            try {
                Mail::send('order',
                    array(
                        'name' => sprintf('%s %s', $member->first_name, $member->last_name),
                        'email' => $member->email,
                        'city' => $request->city,
                        'phone' => $member->phone ?? $request->phone,
                        'content' => $request->information ?? 'Няма',
                        'cart_items' => $cartItems,
                        'shipping' => $shipping,
                        'shipping_method' => $request->shipping_method,
                        'shipping_address' => $shipping_address,
                        'store' => $storeMeta,
                    ),
                    function($message) {
                        $message
                            ->to(config('mail.from.address'))
                            ->subject('Uvel Поръчка');
                    }
                );
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }

            // SEND MAIL TO CLIENT
            $productNames = []; // Populate product names as they are not present in cart_items but needed when serving the client's email
            foreach ($cartItems as $item) {
                $product = Product::select('jewel_id', 'name')->findOrFail($item['attributes']['product_id']);
                $productType = $product->jewel->name;
                $productName = sprintf("%s - %s", $productType, $product->name);
                $productNames[] = $productName;
            }

            try {
                $receiver = isDev() ? config('mail.from.address') : $member->email;
                Mail::send('order-client',
                    array(
                        'name' => sprintf('%s %s', $member->first_name, $member->last_name),
                        'email' => $member->email,
                        'payment_method' => $request->payment_method,
                        'cart_items' => $cartItems,
                        'product_names' => $productNames,
                    ),
                    function($message) {
                        $message
                            ->to($receiver)
                            ->subject('Uvel Поръчка');
                    }
                );
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }

            switch($request->payment_method){
                case 'on_delivery':
                    $payment = new UserPayment();
                    return $payment->storePayment($request);
                    break;
                case 'paypal':
                    $pay = new PayPalPay();
                    return $pay->payWithpaypal($request);
                    break;
                case 'borika':
                    echo "Not implemented";
                    break;
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
