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
use App\CashRegister;
use App\Setting;

class UserPayment extends Model{

	public function storePayment(Request $request){

		$session_id = Auth::user()->getId();
		$userId = Auth::user()->getId();
		$total = round(Cart::session($session_id)->getTotal(),2);
		$subtotal = round(Cart::session($session_id)->getSubTotal(),2);
		$quantity = Cart::session($session_id)->getTotalQuantity();

		if($subtotal <= 0){
			return Redirect::back()->with('error', 'Нямате продукти в количката!');
		}

		$payment = new UserPayment();
		$payment->shipping_method = session('cart_info.0.shipping_method');
		$payment->payment_method = session('cart_info.0.payment_method');
		$payment->shipping_address = session('cart_info.0.shipping_address');
		$payment->user_id = Auth::user()->getId();
		$payment->price = $subtotal;
		$payment->information = session('cart_info.0.information');

		switch(session('cart_info.0.shipping_method')){
			case 'office_address':
				$payment->city = $request->courier_city;
				$payment->phone = $request->courier_phone;
				$payment->shipping_address = session('cart_info.0.shipping_address');
				break;
			case 'home_address':
				$payment->city = $request->city;
				$payment->phone = $request->phone;
				$payment->shipping_address = session('cart_info.0.shipping_address');
				break;
			case 'store':
				$payment->store_id = session('cart_info.0.store_id');
				break;
		}

		$payment->status = 'waiting_user';
		if($payment->payment_method == 'paypal' || $payment->shipping_method == 'office_address' || $payment->shipping_method == 'home_address'){
			$payment->status = 'waiting_staff';
		}

		$payment->save();


		$elements = array('App\UserPaymentProduct', 'App\Selling');

		Cart::session($session_id)->getContent()->each(function($item) use ($elements,$payment,$request){
			foreach($elements as $elem){
				$selling = new $elem();
				$selling->weight = $item->attributes->weight;
				$selling->quantity = $item->quantity;
				$selling->price = $item->price;
				$selling->payment_id = $payment->id;

				switch($item->attributes->type){
					case 'model':
						$selling->model_id = $item->attributes->product_id;
						if(isset($request->modelSize) && is_array($request->modelSize) && isset($request->modelSize[$item->id]))
							if($elem == 'App\Selling'){
								$selling->model_size = $request->modelSize[$item->id];
							}
						break;
					case 'product':
						$selling->product_id = $item->attributes->product_id;
						break;
					case 'box':
						$selling->product_other_id = $item->attributes->product_id;
						break;
				}

				$selling->save();
			}

			// Lower the Quantity for the Products
			switch($item->attributes->type){
				case 'product':
					$product = Product::where('id', $item->attributes->product_id)->first();
					if($product){
						$payment->status = 'reserved';
						if($payment->payment_method == 'paypal' || $payment->shipping_method == 'office_address' || $payment->shipping_method == 'home_address'){
							$product->status = 'sold';
						}
						$product->save();
					}
					break;
				case 'box':
					$box = ProductOther::where('id', $item->attributes->product_id)->first();
					if($box){
						$box->quantity = $box->quantity - $quantity;
						$box->save();
					}
					break;
			}
		});


		$email2sms = new Setting();
		$email2sms = $email2sms->get('email2sms_on_order');

		// Send Email-to-SMS to the admin, only if the environment is not LOCAL or DEVELOPMENT
		if(
			(strtolower($_ENV['APP_ENV'])!=='local'&&strtolower($_ENV['APP_ENV'])!=='development')
			&&
			$email2sms!==''
		){
			Mail::send('sms',array('content' => "Porychka nalichni! ID " . $payment->id), function($message){
				$message->from($_ENV['MAIL_USERNAME']);
				$message->to($email2sms)->subject('Nalichni');
			});
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
		return Redirect::back()->with('success', 'Поръчката Ви бе успешно изпратена!');
		// return Redirect::to('/online')->with('success', 'Поръчката Ви бе успешно изпратена!');
	}

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function store() {
		return $this->belongsTo('App\Store');
	}
}