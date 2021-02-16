<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\ProductTravelling;
use App\Product;
use App\Store;
use Response;
use Redirect;
use Auth;

class ProductTravellingController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$products = Product::where('status', 'available')->take(env('SELECT_PRELOADED'))->get();
		$loggedUser = Auth::user();

		$travelling = new ProductTravelling;
		if(in_array($loggedUser->getRoles(), array('admin','storehouse'))){
			$travelling = $travelling::all();
		}
		else{
			$travelling = $travelling::whereRaw('store_from_id='.$loggedUser->store_id.' OR store_to_id = '.$loggedUser->store_id)->get();
		}
		$stores = Store::all();

		return \View::make('admin/products_travelling/index', array(
			'loggedUser'=>$loggedUser,
			'products'=>$products,
			'travelling'=>$travelling,
			'stores'=>$stores
		));
	}


	public function productstravellingReport(){
		$products_travellings = ProductTravelling::all();
		return view('admin.reports.productstravelling_reports.index', compact(['products_travellings']));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		$validator = Validator::make($request->all(), array('store_to_id'=>'required'));

		if($validator->fails()){
			return Response::json(array('errors'=>$validator->getMessageBag()->toArray()), 401);
		}

		$response = '';
		if(!$request->product_id){
			return Response::json(array('errors'=>array('quantity'=>array(trans('admin/products_travelling.error_no_products')))), 401);
		}
		foreach($request->product_id as $product){
			$check = Product::find($product);

			if(!$check){
				return Response::json(array('errors'=>array('not_found'=>array(trans('admin/products_travelling.error_not_found')))),401);
			}
			if($check->store_id == $request->store_to_id){
				return Response::json(array('errors'=>array('quantity'=>array(trans('admin/products_travelling.error_same_store')))), 401);
			}


			$travel = new ProductTravelling();
			$travel->product_id = $product;
			$travel->store_from_id = $check->store_id;
			$travel->store_to_id  = $request->store_to_id;
			$travel->date_sent = new \DateTime();
			$travel->user_sent = Auth::user()->getId();

			$travel->save();

			$product = Product::find($product);
			$product->store_id = 1;
			$product->status = 'travelling';
			$product->save();

			$response .=  View::make('admin/products_travelling/table', array('product' => $travel, 'proID' => $travel->id))->render();
		}

		return Response::json(array('success' => $response));
	}

	public function addByScan($product){
		$item = Product::where('barcode', $product)->first();

		if(!$item){
			return Response::json(['errors' => ['not_found' => ['Продукта не може да бъде намерен.']]], 401);
		}
		$pass_item = (object)[
			'id' => $item->id,
			'name' => $item->id,
			'weight' => $item->weight,
			'barcode' => $item->barcode
		];

		return Response::json(array('item' => $pass_item));
	}

	public function accept($product){
		$existing_product = Product::where('barcode', $product)->first();

		if(!$existing_product){
			return Response::json(['errors' => ['not_found' => ['Продукта не може да бъде намерен.']]], 401);
		}

		$travel = ProductTravelling::where('product_id',  $existing_product->id)->orderBy('id','DESC')->first();

		if($travel->status=="0"){
			if(in_array(Auth::user()->role, array("admin", "manager"))
				||
				Auth::user()->store_id==$travel->store_to_id
			){
				$travel->status = '1';
				$travel->user_received = Auth::user()->id;
				$travel->date_received = new \DateTime();
				$travel->save();

				$existing_product->store_id = $travel->store_to_id;
				$existing_product->status = 'available';
				$existing_product->save();

				$response = View::make('admin/products_travelling/table', array('product' => $travel))->render();

				return Response::json(array(
					'ID' => $travel->id,
					'table' => $response,
					'success' => 'Продукта бе успешно приет!'
				), 200);
			}
			else{
				return Response::json(['errors' => ['not_found' => ['Продукта не може да бъде намерен като пътуващ към Вашия магазин.']]], 401);
			}
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\ProductTravelling  $productTravelling
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(ProductTravelling $product){
		if($product){
			$originProduct = Product::find($product->product_id);
			$originProduct->store_id = $product->store_from_id;
			$originProduct->status = 'available';
			$originProduct->save();

			$product->delete();
			return Response::json(array('success' => 'Успешно изтрито!'));
		}
	}
}
