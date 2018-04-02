<?php

namespace App\Http\Controllers;

use App\Products_others_types;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;

class ProductsOthersTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products_others_types = Products_others_types::all();
        
        return \View::make('admin/products_others_types/index', array('products_others_types' => $products_others_types));
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
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $type = Products_others_types::create($request->all());

        return Response::json(array('success' => View::make('admin/products_others_types/table',array('type'=>$type))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products_others_types  $products_others_types
     * @return \Illuminate\Http\Response
     */
    public function show(Products_others_types $products_others_types)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products_others_types  $products_others_types
     * @return \Illuminate\Http\Response
     */
    public function edit(Products_others_types $products_others_types, $type)
    {
        $type = Products_others_types::find($type);

        return \View::make('admin/products_others_types/edit', array('type' => $type));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products_others_types  $products_others_types
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products_others_types $products_others_types, $type)
    {
        $type = Products_others_types::find($type);
        
        $type->name = $request->name;
        $type->save();
        
        return Response::json(array('table' => View::make('admin/products_others_types/table',array('type'=>$type))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products_others_types  $products_others_types
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products_others_types $products_others_types)
    {
        //
    }
}
