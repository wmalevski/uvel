<?php

namespace App\Http\Controllers;

use App\Models;
use App\Jewels;
use App\Prices;
use App\Stones;
use App\Model_stones;
use App\Product;
use Illuminate\Http\Request;

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
        $prices = Prices::where('type', 'sell')->get();
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
        $validatedData = $request->validate([
            'name' => 'required',
            'jewel' => 'required',
            'retail_price' => 'required',
            'wholesale_price' => 'required'
        ]);

        $model = Models::create($request->all());

        foreach($request->stones as $key => $stone){
            $model_stones = new Model_stones();
            $model_stones->model = $model->id;
            $model_stones->stone = $stone;
            $model_stones->amount = $request->stone_amount[$key];
            $model_stones->save();
        }

        if (isset($request->release_product)) {
            $product = new Product();
            $product->model = $model->id;
            $product->type = $request->jewel;
            $product->weight = $request->weight;
            $product->price_list = $request->retail_price;
            $product->size = $request->size;
            $product->workmanship = '1';
            $product->price = '1';
            $product->code = 'AAADDDDDDD8333';
        }

        return redirect('admin/models');
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
        
        return \View::make('models/edit', array('model' => $model, 'jewels' => $jewels, 'prices' => $prices, 'stones' => $stones));
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

        return \View::make('models/edit', array('model' => $model, 'jewels' => $jewels, 'prices' => $prices, 'stones' => $stones));
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
