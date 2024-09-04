<?php

namespace App\Http\Controllers;

use App\UserPayment;
use App\Model;
use App\ModelOrder;
use App\Store;
use App\DiscountCode;
use Auth;
use Cart;
use App\UserPaymentProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;
use \Darryldecode\Cart\CartCondition as CartCondition;
use \Darryldecode\Cart\Helpers\Helpers as Helpers;
use Response;
use App\PaymentDiscount;
use App\Setting;

class OnlineSellingsController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$sellings = UserPayment::orderBy("created_at","DESC")->paginate(Setting::where('key','per_page')->first()->value ?? 30);
		return view('admin.selling.online.index', compact('sellings'));
	}



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\ModelOrder  $modelOrder
	 * @return \Illuminate\Http\Response
	 */
	public function edit(UserPayment $selling){
		$stores = Store::all();
		$products = UserPaymentProduct::where('payment_id', $selling->id)->get();
		$discounts = PaymentDiscount::where('payment_id', $selling->id)->get();
		$discount_codes = array();
		if($discounts->count()>0){
			foreach($discounts as $k=>$v){
				$discount_codes[$v->discount_code_id]=DiscountCode::where('barcode',$v->discount_code_id)->first()->discount;
			}
		}

		$orderInfo = UserPayment::where('id',$selling->id)->first();
		$orderInfo = ($orderInfo->count()>0 ? $orderInfo->information : null );

		return \View::make('admin/selling/online/edit', array(
			'selling' => $selling,
			'stores' => $stores,
			'products' => $products,
			'discount_codes' => $discount_codes,
			'orderInfo' => $orderInfo
		));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\UserPayment  $modelOrder
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, UserPayment $selling){
		$selling->status = 'done';
		$selling->save();

		return Response::json(array('ID' => $selling->id, 'table' => View::make('admin/selling/online/table',array('selling'=>$selling))->render()));
	}


	public function setDiscount(Request $request, $barcode){
		$userId = Auth::user()->getId();

		$result = false;
		$setDiscount = $barcode;

		if(strlen($barcode) == 13){
			$discount = new DiscountCode;
			$result = json_encode($discount->check($barcode));

			if($result == 'true'){
				$card = DiscountCode::where('barcode', $barcode)->first();
				$setDiscount = $card->discount;
			}
		}

		if(isset($setDiscount)){
			$condition = new CartCustomCondition(array(
				'name' => $setDiscount,
				'type' => 'discount',
				'target' => 'subtotal',
				'value' => '-'.$setDiscount.'%',
				'attributes' => array(
					'discount_id' => $setDiscount,
					'description' => 'Value added tax',
					'more_data' => 'more data here'
				)
			));

			Cart::condition($condition);
			Cart::session($userId)->condition($condition);

			$total = round(Cart::session($userId)->getTotal(),2);
			$subtotal = round(Cart::session($userId)->getSubTotal(),2);
			$subTotal = round(Cart::session(Auth::user()->getId())->getSubTotal(),2);
			$cartConditions = Cart::session($userId)->getConditions();
			$conds = array();
			$priceCon = 0;

			if(count($cartConditions) > 0){
				foreach(Cart::session(Auth::user()->getId())->getConditions() as $cc){
					$priceCon += $cc->getCalculatedValue($subTotal);
				}
			}

			foreach($cartConditions as $key => $condition){
				$conds[$key]['value'] = $condition->getValue();
				$conds[$key]['attributes'] = $condition->getAttributes();
			}

			$dds = round($subTotal - ($subTotal/1.2), 2);

			return Response::json(array(
				'success' => true,
				'total' => $total,
				'subtotal' => $subtotal,
				'condition' => $conds,
				'priceCon' => $priceCon,
				'dds' => $dds
			));
		}
	}
}
