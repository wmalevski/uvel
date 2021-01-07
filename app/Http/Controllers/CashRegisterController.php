<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\CashRegister;
use App\Store;
use Response;
use Redirect;
use Auth;

class CashRegisterController extends Controller{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$register = new CashRegister;
		$register = CashRegister::where('store_id', CashRegister::$store)->get();

		$stores = Store::all();

		return \View::make('admin/cash_register/index', array(
			'stores' => $stores,
			'def_store' => CashRegister::$store,
			'register' => $register
		));
	}

	public function ajaxFilter(Request $request){
		$validator = Validator::make( $request->all(), array(
			'selectedStore' => 'required'
		));

		if($validator->fails()){
			return Response::json(array('errors' => $validator->getMessageBag()->toArray()), 400);
		}

		$store_id = $request->selectedStore;

		// Only administrators should be able to view data for other stores
		if(Auth::user()->role !== 'admin'){
			$store_id = Auth::user()->getStore()->id;
		}

		$result = '';

		$register = new CashRegister;
		$register = CashRegister::where('store_id', $store_id)->get();

		foreach($register as $entry){
			$result .= View::make('admin/cash_register/table', array(
				'entry' => $entry
			))->render();
		}

		if(empty($result)){
			return Response::json(array('error'=>'<div class="">Няма записани Движения за този магазин</div>'));
		}

		return Response::json(array('table'=>$result));
	}
}