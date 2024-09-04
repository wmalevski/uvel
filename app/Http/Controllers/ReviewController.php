<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Auth;
use Response;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->product)) { // admin/reviews/{product}
            $reviews = Review::where('product_id', $request->product)->orderBy('id', 'DESC')->paginate(Setting::where('key','per_page')->first()->value ?? 30);
        } elseif (isset($request->model)) { // admin/reviews/{model}
            $reviews = Review::where('model_id', $request->model)->orderBy('id', 'DESC')->paginate(Setting::where('key','per_page')->first()->value ?? 30);
        } elseif (isset($request->products_other)) { // admin/reviews/{products_other}
            $reviews = Review::where('product_others_id', $request->products_other)->orderBy('id', 'DESC')->paginate(Setting::where('key','per_page')->first()->value ?? 30);
        } else {
            $reviews = Review::orderBy('id', 'DESC')->paginate(Setting::where('key','per_page')->first()->value ?? 30);
        }

        return \View::make('admin/reviews/index', array('reviews' => $reviews));
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return \View::make('admin/reviews/show', array('review' => $review));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
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
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        if($review){
            $review->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));  
        }
    }
}
