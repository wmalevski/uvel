<?php

namespace App\Http\Controllers;

use App\Products;
use App\Models;
use App\Jewels;
use App\Prices;
use App\Stones;
use App\Model_stones;
use Illuminate\Http\Request;
use Uuid;
use App\Gallery;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\JsonResponse;
use Response;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();
        $models = Models::all();
        $jewels = Jewels::all();
        $prices = Prices::where('type', 'sell')->get();
        $stones = Stones::all();

        $pass_stones = array();

        foreach($stones as $stone){
            $pass_stones[] = (object)[
                'value' => $stone->id,
                'label' => $stone->name
            ];
        }

        return \View::make('admin/products/index', array('products' => $products, 'jewels' => $jewels, 'models' => $models, 'prices' => $prices, 'stones' => $stones, 'jsStones' =>  json_encode($pass_stones, JSON_UNESCAPED_SLASHES )));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function chainedSelects(Request $request, $model){
        $product = new Products;
        return $product->chainedSelects($model);
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
            'jewelsTypes' => 'required',
            'retail_price' => 'required',
            'wholesale_prices' => 'required',
            'weight' => 'required',
            'size' => 'required'
        ]); 

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $file_data = $request->input('images'); 
        foreach($file_data as $img){
            $file_name = 'productimage_'.uniqid().time().'.png';
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
            file_put_contents(public_path('uploads/products/').$file_name, $data);

            $photo = new Gallery();
            $photo->photo = $file_name;
            $photo->row_id = 1;
            $photo->table = 'products';

            $photo->save();
        }

        $product = new Products();
        $product->id = Uuid::generate()->string;
        $product->model = $request->model;
        $product->jewel_type = $request->jewelsTypes;
        $product->weight = $request->weight;
        $product->retail_price = $request->retail_price;
        $product->wholesale_price  = $request->wholesale_prices;
        $product->size = $request->size;
        $product->workmanship = $request->workmanship;
        $product->price = $request->price;
        $product->code = unique_number('products', 'code', 4);
        $product->barcode = '380'.unique_number('products', 'barcode', 4).$product->code; 
        $product->save();
        
        return Response::json(array('table' => View::make('admin/products/table',array('product'=>$product))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        //
    }
}
