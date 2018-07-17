<?php

namespace App\Http\Controllers;

use App\ProductOtherType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;

class ProductOtherTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products_others_types = ProductOtherType::all();
        
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
            'name' => 'required|unique:products_others_types,name'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $type = ProductOtherType::create($request->all());

        return Response::json(array('success' => View::make('admin/products_others_types/table',array('type'=>$type))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductOtherType  $roductOtherType
     * @return \Illuminate\Http\Response
     */
    public function show(ProductOtherType $productOtherType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductOtherType  $roductOtherType
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductOtherType $productOtherType)
    {
        return \View::make('admin/products_others_types/edit', array('type' => $productOtherType));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductOtherType  $roductOtherType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductOtherType $productOtherType)
    {
        $productOtherType->name = $request->name;
        $productOtherType->save();
        
        return Response::json(array('ID' => $productOtherType->id, 'table' => View::make('admin/products_others_types/table',array('type'=>$productOtherType))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductOtherType  $productOtherType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductOtherType $productOtherType)
    {
        if($productOtherType){
            $productOtherType->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}