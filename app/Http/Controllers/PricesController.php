<?php

namespace App\Http\Controllers;

use App\Prices;
use App\Materials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Models;
use Response;
use Illuminate\Support\Facades\View;
use App\Products;
use App\Jewels;

class PricesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $materials = Materials::all();
        
        if ($request->isMethod('post')){
            return redirect()->route('view-price', ['material' => $request->material]);
        }

        return \View::make('admin/prices/index', array('materials' => $materials));
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
            'slug' => 'required',
            'price' => 'required|regex:/^\d*(\.\d{1,3})?$/',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $price = Prices::create($request->all());
        return Response::json(array('success' => View::make('admin/prices/table',array('price'=>$price, 'type' => $request->type))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prices  $prices
     * @return \Illuminate\Http\Response
     */
    public function show(Prices $prices, $material)
    {
        $material = Materials::find($material);

        if($material){
            $prices = Prices::where('material', $material->id)->get();

            return view('admin/prices/show', compact('prices', 'material'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prices  $prices
     * @return \Illuminate\Http\Response
     */
    public function edit(Prices $prices, $price)
    {
        $price = Prices::find($price);
        
        return \View::make('admin/prices/edit', array('price' => $price));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prices  $prices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prices $prices, $price)
    {
        $price = Prices::find($price);
        
        $price->slug = $request->slug;
        $price->price = $request->price;
        $price->type = $request->type;

        $validator = Validator::make( $request->all(), [
            'slug' => 'required',
            'price' => 'required|regex:/^\d*(\.\d{1,3})?$/',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }
        
        $price->save();
        
        return Response::json(array('ID' => $price->id, 'table' => View::make('admin/prices/table', array('price' => $price, 'type' => $request->type))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prices  $prices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prices $prices, $price)
    {
        $price = Prices::find($price);
        
        if($price){
            $usingWProduct = Products::where('wholesale_price', $price->id)->count();
            $usingRProduct = Products::where('retail_price', $price->id)->count();

            $usingWModel = Models::where('wholesale_price', $price->id)->count();
            $usingRModel = Models::where('retail_price', $price->id)->count();

            if($usingWProduct || $usingRProduct || $usingWModel || $usingRModel){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{

                $price->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }

    public function getByMaterial($material){
        $prices = Prices::where(
            [
                ['material', '=', $material],
                ['type', '=', 'sell']
            ]
        )->get();

        $prices_retail = array();

        $priceBuy = Prices::where(
            [
                ['material', '=', $material],
                ['type', '=', 'buy']
            ]
        )->first();

        // $prices_retail[0] = (object)[
        //     'id' => '',
        //     'material' => '',
        //     'slug' => 'Избери цена',
        //     'price' => ''
        // ];

        $models = Models::where(
            [
                ['jewel', '=', $material],
            ]
        )->get();

        $pass_models = array();
        
        foreach($models as $model){
            $pass_models[] = (object)[
                'value' => $model->id,
                'label' => $model->name,
            ];
        }
        
        foreach($prices as $price){

            $prices_retail[] = (object)[
                'id' => $price->id,
                'material' => $price->material,
                'slug' => $price->slug.' - '.$price->price.'лв',
                'price' => $price->price
            ];
        }

        return Response::json(array('prices' => $prices_retail, 'pass_models' => $models, 'priceBuy' => $priceBuy->price));
    }
}