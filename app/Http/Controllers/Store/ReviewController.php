<?php

namespace App\Http\Controllers\Store;

use App\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Auth;

class ReviewController extends BaseController{

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		$validator = Validator::make($request->all(), array(
			'rating' => 'required|integer',
			'type'  => 'required|string'
		));

		if($validator->fails()){
			return Redirect::back()->withErrors($validator);
		}

		$review = new Review();
		if(isset($request->content)){$review->content = $request->content;}
		$review->rating = $request->rating;
		$review->user_id = ( Auth::check() ? Auth::user()->getId() : NULL);

		switch($request->type){
			case 'product':
				$review->product_id = $request->product_id;
				break;
			case 'model':
				$review->model_id = $request->model_id;
				break;
			case 'product_other':
				$review->product_others_id = $request->product_others_id;
				break;
		}

		$review->save();

		return Redirect::back()->with('success.review', 'Ревюто ви беше изпратено успешно');

	}
}