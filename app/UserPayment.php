<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\PaypalPay;
use App\ProductOther;
use App\Product;
use App\UserPaymentProduct;
use Auth;
use Cart;
use Mail;

class UserPayment extends Model
{
    public function storePayment(){
        $session_id = Auth::user()->getId();
        $userId = Auth::user()->getId();
        $total = round(Cart::session($session_id)->getTotal(),2);
        $subtotal = round(Cart::session($session_id)->getSubTotal(),2);
        $quantity = Cart::session($session_id)->getTotalQuantity();
        
        $items = [];
        
        Cart::session($session_id)->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        if($subtotal > 0){
            $payment = new UserPayment();
            $payment->shipping_method = session('cart_info.0.shipping_method');
            $payment->payment_method = session('cart_info.0.payment_method');
            $payment->shipping_address = session('cart_info.0.shipping_address');
            $payment->user_id = Auth::user()->getId();
            $payment->price = $subtotal;
            $payment->information = session('cart_info.0.information');

            if(session('cart_info.0.shipping_method') == 'office_address' || session('cart_info.0.shipping_method') == 'home_address'){
                $payment->shipping_address = session('cart_info.0.shipping_address');
            } else if(session('cart_info.0.shipping_method') == 'store'){
                $payment->store_id = session('cart_info.0.store_id');
            }

            if($payment->payment_method == 'paypal' || $payment->shipping_method == 'office_address' || $payment->shipping_method == 'home_address'){
                $payment->status = 'done';
            }else{
                $payment->status = 'waiting_user';
            }

            $payment->save();

            //send sms to the admin
            Mail::send('sms',
                array(
                    'content' => "Porychka nalichni! ID " . UserPayment::all()->last()->pluck('id')
                ), function($message) {
                    $message->from("info@uvel.bg");
                    $message->to("359888770160@sms.telenor.bg")->subject('Nalichni');
            });

            $elements = ['App\UserPaymentProduct', 'App\Selling'];

            foreach($items as $item){
                foreach ($elements as $elem) {
                    $selling = new $elem();
                    $selling->weight = $item->attributes->weight;
                    $selling->quantity = $item->quantity;
                    $selling->price = $item->price;
                    $selling->payment_id = $payment->id;

                    if ($item->attributes->type == 'model') {
                        $selling->model_id = $item->attributes->product_id;
                    } elseif ($item->attributes->type == 'product') {
                        $selling->product_id = $item->attributes->product_id;
                    } elseif ($item->attributes->type == 'box') {
                        $selling->product_other_id = $item->attributes->product_id;
                    }

                    $selling->save();
                }
            }
            
            foreach(Cart::session($userId)->getContent() as $item)
            {
                if($item->attributes->type == 'product'){
                    $product = Product::where('id', $item->attributes->product_id)->first();

                    if($product){
                        if($payment->payment_method == 'paypal' || $payment->shipping_method == 'office_address' || $payment->shipping_method == 'home_address'){
                            $product->status = 'sold';
                        } else{
                            $payment->status = 'reserved';
                        }
                        
                        $product->save();
                    }
                } else if($item->attributes->type == 'box'){
                    $box = ProductOther::where('id', $item->attributes->product_id)->first();

                    if($box){
                        $box->quantity = $box->quantity - $quantity;
                        $box->save();
                    }
                }
            }

            //Store the notification
            $history = new History();

            $history->action = 'payment';
            $history->subaction = 'successful';
            $history->user_id = Auth::user()->getId();
            $history->table = 'payments';
            $history->payment_id = $payment->id;

            $history->save();

            Cart::clear();
            Cart::clearCartConditions();
            Cart::session($session_id)->clear();
            Cart::session($session_id)->clearCartConditions();

            session()->forget('cart_info');
            return Redirect::to('/online')->with('success', 'Нямате продукти в количката!');
        }else{
            return Redirect::back()->with('error', 'Нямате продукти в количката!');
        }
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function store() {
        return $this->belongsTo('App\Store');
    }
}
