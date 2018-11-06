<?php

namespace App\Http\Controllers\Store;

use App\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Auth;

class ReviewController extends Controller
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
        $validator = Validator::make( $request->all(), [
            'title' => 'required|string',
            'content' => 'required|string|max:1500',
            'rating' => 'required|integer',
            'type'  => 'required|string'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $review = new Review();
        $review->title = $request->title;
        $review->content = $request->content;
        $review->rating = $request->rating;
        $review->user_id = Auth::user()->getId();
        
        if($request->type == 'product') {
            $review->product_id = $request->product_id;
        }elseif($request->type == 'model') {
            $review->model_id = $request->model_id;
        }elseif($request->type == 'product_other') {
            $review->product_others_id = $request->product_others_id;
        }
        $review->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function show(Reviews $reviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function edit(Reviews $reviews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reviews $reviews)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reviews $reviews)
    {
        //
    }
}
