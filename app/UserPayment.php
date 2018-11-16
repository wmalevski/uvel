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
            $payment->user_id = Auth::user()->getId();
            $payment->price = $subtotal;
            $payment->information = session('cart_info.0.information');

            if(session('cart_info.0.shipping_method') == 'ekont'){
                $payment->ekont_address = session('cart_info.0.ekont_address');
            } else if(session('cart_info.0.shipping_method') == 'store'){
                $payment->store_id = session('cart_info.0.store_id');
            }

            $payment->status = 'approved';

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

                $selling->status = 'waiting_user';

                $selling->save();
            }
            
            foreach(Cart::session($userId)->getContent() as $item)
            {
                if($item['attributes']->type == 'product'){
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
            Cart::session($session_id)->clear();
            Cart::session($session_id)->clearCartConditions();

            session()->forget('cart_info');
            return 'ei sladyr';
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
