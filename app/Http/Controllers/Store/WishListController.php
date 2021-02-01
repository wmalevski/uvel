<?php

namespace App\Http\Controllers\Store;

use App\Review;
use App\WishList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Auth;
use Response;

class WishListController extends BaseController{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$wishList = WishList::where('user_id',Auth::user()->getId())->get();

		return \View::make('store.pages.wishlists.index', array('wishList'=>$wishList));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, $type, $item){
		$wishList = new WishList();

		// Anonymous
		if(Auth::user() == NULL){
			return redirect()->route('login');
		}

		$check = WishList::where(array(
			'product_id'=>$item,
			'user_id'=>Auth::user()->getId()
		))->orWhere(array(
			'model_id'=>$item,
			'user_id'=>Auth::user()->getId()
		))->orWhere(array(
			'product_others_id'=>$item,
			'user_id'=>Auth::user()->getId()
		))->first();

		if($check){
			return Response::json(array('success' => 'Този продукт вече го имате запазен!'));
		}


		switch($type){
			case 'product':
				$wishList->product_id = $item;
				break;
			case 'model':
				$wishList->model_id = $item;
				break;
			case 'product_other':
				$wishList->product_others_id = $item;
				break;
		}
		$wishList->user_id=Auth::id();
		$wishList->save();

		return Response::json(array('success' => 'Продуктът беше запазен успешно!'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\WishList  $wishList
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(WishList $wishList){
		if($wishList){
			$wishList->delete();
			return Redirect::back()->with('success', 'Продуктът беше успешно премахнат от списъка.');
		}
	}
}