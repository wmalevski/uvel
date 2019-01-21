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

class WishListController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wishList = WishList::where([['user_id', '=', Auth::user()->getId()]])->get();

        return \View::make('store.pages.wishlists.index', array('wishList' => $wishList));

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
    public function store(Request $request, $type, $item)
    {
        $wishList = new WishList();
        $wishList->user_id = Auth::user()->getId();

        $check = WishList::where('product_id', $item)->orWhere('model_id', $item)->orWhere('product_others_id', $item)->first();

        if(!$check){
            if ($type == 'product') {
                $wishList->product_id = $item;
            } elseif ($type == 'model') {
                $wishList->model_id = $item;
            } elseif ($type == 'product_other') {
                $wishList->product_others_id = $item;
            }
            
            $wishList->save();

            return Response::json(array('success' => 'Продуктът беше запазен успешно!'));
        }else{
            return Response::json(array('success' => 'Този продукт вече го имате запазен!'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WishList  $wishList
     * @return \Illuminate\Http\Response
     */
    public function show(WishList $wishList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WishList  $wishList
     * @return \Illuminate\Http\Response
     */
    public function edit(WishList $wishList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WishList  $wishList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WishList $wishList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WishList  $wishList
     * @return \Illuminate\Http\Response
     */
    public function destroy(WishList $wishList)
    {
        if($wishList){
            $wishList->delete();
            return Redirect::back()->with('success', 'Продуктът беше успешно премахнат от списъка.');
        }
    }
}
