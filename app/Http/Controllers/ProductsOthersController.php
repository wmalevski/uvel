<?php

namespace App\Http\Controllers;

use App\Products_others;
use App\Products_others_types;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;

class ProductsOthersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products_others = Products_others::all();
        $types = Products_others_types::all();

        return \View::make('admin/products_others/index', array('products_others' => $products_others, 'types' => $types));
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
            'model' => 'required',
            'type' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]); 

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $product = Products_others::create($request->all());

        return Response::json(array('success' => View::make('admin/products_others/table',array('product'=>$product))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products_others  $products_others
     * @return \Illuminate\Http\Response
     */
    public function show(Products_others $products_others)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products_others  $products_others
     * @return \Illuminate\Http\Response
     */
    public function edit(Products_others $products_others)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products_others  $products_others
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products_others $products_others)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products_others  $products_others
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products_others $products_others)
    {
        //
    }
}
