<?php

namespace App\Http\Controllers;

use App\Price;
use App\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Model;
use App\ModelOption;
use Response;
use Illuminate\Support\Facades\View;
use App\Product;
use App\Jewel;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $materials = Material::all();
        
        if ($request->isMethod('post')){
            return redirect()->route('view_price', ['material' => $request->material_id]);
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

        $price = Price::create($request->all());
        return Response::json(array('success' => View::make('admin/prices/table',array('price'=>$price, 'type' => $request->type))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Price  $prices
     * @return \Illuminate\Http\Response
     */
    public function show(Price $price, $material)
    {
        if($material){
            $prices = Price::where('material_id', $material)->get();
            $material = Material::find($material);
          
            return view('admin/prices/show', compact('prices', 'material'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prices  $prices
     * @return \Illuminate\Http\Response
     */
    public function edit(Price $price)
    {
        return \View::make('admin/prices/edit', array('price' => $price));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Price  $prices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Price $price)
    {       
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
     * @param  \App\Price  $prices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Price $price)
    { 
        if($price){
            $usingWProduct = Product::where('wholesale_price_id', $price->id)->count();
            $usingRProduct = Product::where('retail_price_id', $price->id)->count();

            $usingWModel = Models::where('wholesale_price_id', $price->id)->count();
            $usingRModel = Models::where('retail_price_id', $price->id)->count();

            if($usingWProduct || $usingRProduct || $usingWModel || $usingRModel){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{

                $price->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }

    public function getByMaterial($material, $model){
        $checkExisting = ModelOption::where([
            ['model_id', '=', $model],
            ['material_id', '=', $material],
            ['default', '=', 'yes']
        ])->first();

        

        $retail_prices = Price::where(
            [
                ['material_id', '=', $material],
                ['type', '=', 'sell']
            ]
        )->get();

        $wholesale_prices = Price::where(
            [
                ['material_id', '=', $material],
                ['type', '=', 'sell']
            ]
        )->get();

        $prices_retail = array();
        $prices_wholesale = array();

        $priceBuy = Price::where(
            [
                ['material_id', '=', $material],
                ['type', '=', 'buy']
            ]
        )->first();

        $models = Model::where(
            [
                ['jewel_id', '=', $material],
            ]
        )->get();

        $pass_models = array();
        
        foreach($models as $model){
            $pass_models[] = (object)[
                'value' => $model->id,
                'label' => $model->name,
            ];
        }
        
        foreach($retail_prices as $price){

            if($checkExisting){
                if($price->id == $checkExisting->retail_price_id){
                    $selected = true;
                }else{
                    $selected = false;
                }
            }else{
                $selected = false;
            }

            $prices_retail[] = (object)[
                'id' => $price->id,
                'material' => $price->material_id,
                'slug' => $price->slug.' - '.$price->price.'лв',
                'price' => $price->price,
                'selected' => $selected
            ];
        }

        foreach($wholesale_prices as $price){
            
            if($checkExisting){
                if($price->id == $checkExisting->wholesale_price_id){
                    $selected = true;
                }else{
                    $selected = false;
                }
            }else{
                $selected = false;
            }

            $prices_wholesale[] = (object)[
                'id' => $price->id,
                'material' => $price->material_id,
                'slug' => $price->slug.' - '.$price->price.'лв',
                'price' => $price->price,
                'selected' => $selected
            ];
        }

        return Response::json(array(
            'retail_prices' => $prices_retail, 
            'wholesale_prices' => $prices_wholesale, 
            'pass_models' => $models, 
            'pricebuy' => $priceBuy->price));
    }
}