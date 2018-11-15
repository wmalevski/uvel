<?php

namespace App\Http\Controllers\Store;

use App\UserPayment;
use Illuminate\Http\Request;
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
        $session_id = session()->getId();
        $userId = Auth::user()->getId();
        
        $total = round(Cart::session($session_id)->getTotal(),2);
        $subtotal = round(Cart::session($session_id)->getSubTotal(),2);
        $quantity = Cart::session($session_id)->getTotalQuantity();

        $items = [];
        
        Cart::session($session_id)->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        $payment = new UserPayment();
        $payment->shipping_method = $request->shipping_method;
        $payment->payment_method = $request->payment_method;
        $payment->user_id = Auth::user()->getId();
        $payment->price = $request->amount;
        $payment->information = $request->information;

        if($request->shipping_method == 'ekont'){
            $payment->ekont_address = $request->ekont_address;
        } else if($request->shipping_method == 'store'){
            $payment->store_id = $request->store_id;
        }

        if($request->payment_method == 'on_delivery'){

        } else if ($request->payment_method == 'paypal'){
            $pay = new PaypalPay();
            return $pay->payWithpaypal($request);
        } else if ($request->payment_method == 'borika'){
            
        }

        $payment->save();

        foreach($items as $item){
            $selling = new UserPaymentProduct();
            $selling->weight = $item['attributes']->weight;
            $selling->quantity = $item->quantity;
            $selling->price = $item->price;
            $selling->payment_id = $payment->id;

            if($item['attributes']->type == 'model'){
                $selling->model_id = $item->id;
            } elseif($item['attributes']->type == 'product'){
                $selling->product_id = $item->id;
            } elseif($item['attributes']->type == 'box'){
                $selling->product_other_id = $item->id;
            }

            $selling->save();
        }
        
        foreach(Cart::session($userId)->getContent() as $item)
        {
            if($item['attributes']->type == 'model'){
                $model = Model::find($item->id);

                if($model){
                    $model->status = 'returned';
                    $model->save();
                }
            } else if($item['attributes']->type == 'product'){
                $product = Product::find($item->id);

                if($product){
                    $product->status = 'sold';
                    $product->save();
                }
            } else if($item['attributes']->type == 'box'){

            }
        }

        Cart::clear();
        Cart::clearCartConditions();
        Cart::session($userId)->clear();
        Cart::session($userId)->clearCartConditions();
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
