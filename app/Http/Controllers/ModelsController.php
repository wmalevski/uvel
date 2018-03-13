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
use Uuid;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

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

        $pass_stones = array();
        
        foreach($stones as $stone){
            $pass_stones[] = [
                'value' => $stone->id,
                'label' => $stone->name.' ('.\App\Stone_contours::find($stone->contour)->name.', '.\App\Stone_sizes::find($stone->size)->name.' )'
            ];
        }

        return \View::make('admin/models/index', array('jsStones' =>  json_encode($pass_stones), 'jewels' => $jewels, 'models' => $models, 'prices' => $prices, 'stones' => $stones));
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

        // foreach($request->images as $img){
        //     echo $img;
        // }

        // die;

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
            $product->id = Uuid::generate()->string;
            $product->name = $request->name;
            $product->model = $model->id;
            $product->jewel_type = $request->jewel;
            $product->weight = $request->weight;
            $product->retail_price = $request->retail_price;
            $product->wholesale_price  = $request->wholesale_price;
            $product->size = $request->size;
            $product->workmanship = $request->workmanship;
            $product->price = $request->price;
            $product->code = unique_number('products', 'code', 4);

            $barcode = str_replace('-', '', $product->id);

            $barcode = pack('h*', $barcode);
            $barcode = unpack('L*', $barcode);

            $newbarcode = '';

            foreach($barcode as $bars){
                $newbarcode .= $bars;
            }

            $product->barcode = '380'.unique_number('products', 'barcode', 4).$product->code; 
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
