<?php

namespace App\Http\Controllers;

use App\Models;
use App\Jewels;
use App\Prices;
use App\Stones;
use App\Model_stones;
use App\Products;
use App\Product_stones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;

class ModelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Models::all();
        $jewels = Jewels::all();
        $prices = Prices::all();
        $stones = Stones::all();

        return \View::make('admin/models/index', array('jewels' => $jewels, 'models' => $models, 'prices' => $prices, 'stones' => $stones));
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
            'name' => 'required',
            'jewel' => 'required',
            'retail_price' => 'required',
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        foreach($request->images as $img){
            echo $img;
        }

        die;

        $model = Models::create($request->all());

        foreach($request->stones as $key => $stone){
            $model_stones = new Model_stones();
            $model_stones->model = $model->id;
            $model_stones->stone = $stone;
            $model_stones->amount = $request->stone_amount[$key];
            $model_stones->save();
        }

        if ($request->release_product == true) {
            $product = new Products();
            $product->name = $request->name;
            $product->model = $model->id;
            $product->type = $request->jewel;
            $product->weight = $request->weight;
            $product->price_list = $request->retail_price;
            $product->size = $request->size;
            $product->workmanship = $request->workmanship;
            $product->price = $request->price;
            $product->code = unique_random('products', 'code', 6);

            $product->save();

            foreach($request->stones as $key => $stone){
                $product_stones = new Product_stones();
                $product_stones->product = $product->id;
                $product_stones->model = $model->id;
                $product_stones->stone = $stone;
                $product_stones->amount = $request->stone_amount[$key];
                $product_stones->save();
            }
        }

        return Response::json(array('success' => View::make('admin/models/table',array('model'=>$model))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function show(Models $models)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function edit(Models $models, $model)
    {
        $model = Models::find($model);
        $jewels = Jewels::all();
        $prices = Prices::where('type', 'sell')->get();
        $stones = Stones::all();
        
        return Response::json(array('success' => View::make('admin/models/edit',array('model' => $model, 'jewels' => $jewels, 'prices' => $prices, 'stones' => $stones))->render()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Models $models, $model)
    {
        $model = Models::find($model);

        $jewels = Jewels::all();
        $prices = Prices::where('type', 'sell')->get();
        $stones = Stones::all();
        
        $model->name = $request->name;
        $model->jewel = $request->jewel;
        $model->retail_price = $request->retail_price;
        $model->wholesale_price = $request->wholesale_price;
        $model->weight = $request->weight;
        
        $model->save();

        return Response::json(array('success' => View::make('admin/models/edit',array('model' => $model, 'jewels' => $jewels, 'prices' => $prices, 'stones' => $stones))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function destroy(Models $models)
    {
        //
    }
}
