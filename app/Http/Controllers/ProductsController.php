<?php

namespace App\Http\Controllers;

use App\Products;
use App\Models;
use App\Jewel;
use App\Price;
use App\Stone;
use App\Model_stones;
use App\Product_stones;
use Illuminate\Http\Request;
use Uuid;
use App\Gallery;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\JsonResponse;
use Response;
use File;

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
        $jewels = Jewel::all();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::all();

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
            'jewelsTypes' => 'required',
            'retail_price' => 'required',
            'wholesale_prices' => 'required',
            'weight' => 'required|numeric|between:0.1,10000',
            'size' => 'required|numeric|between:0.1,10000',
            'workmanship' => 'required|numeric|between:0.1,500000',
            'price' => 'required|numeric|between:0.1,500000'
        ]); 

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $path = public_path('uploads/products/');
        
        File::makeDirectory($path, 0775, true, true);

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
        $product->name = 'Test name';
        $product->model = $request->model;
        $product->jewel_type = $request->jewelsTypes;
        $product->weight = $request->weight;
        $product->retail_price = $request->retail_price;
        $product->wholesale_price  = $request->wholesale_prices;
        $product->size = $request->size;
        $product->workmanship = $request->workmanship;
        $product->price = $request->price;
        $product->code = 'P'.unique_random('products', 'code', 7);
        $bar = '380'.unique_number('products', 'barcode', 7).'1'; 

        if($request->for_wholesale == false){
            $product->for_wholesale = 'no';
        } else{
            $product->for_wholesale = 'yes';
        }

        $digits =(string)$bar;
        // 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
        $even_sum = $digits{1} + $digits{3} + $digits{5} + $digits{7} + $digits{9} + $digits{11};
        // 2. Multiply this result by 3.
        $even_sum_three = $even_sum * 3;
        // 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
        $odd_sum = $digits{0} + $digits{2} + $digits{4} + $digits{6} + $digits{8} + $digits{10};
        // 4. Sum the results of steps 2 and 3.
        $total_sum = $even_sum_three + $odd_sum;
        // 5. The check character is the smallest number which, when added to the result in step 4,  produces a multiple of 10.
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;
        $product->barcode = $digits . $check_digit;

        $product->save();

        foreach($request->stones as $key => $stone){
            if($stone) {
                $product_stones = new Product_stones();
                $product_stones->product = $product->id;
                $product_stones->model = $request->model;
                $product_stones->stone = $stone;
                $product_stones->amount = $request->stone_amount[$key];
                $product_stones->save();
            }
        }

        $file_data = $request->input('images'); 
        
        foreach($file_data as $img){
            $file_name = 'productimage_'.uniqid().time().'.png';
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
            file_put_contents(public_path('uploads/products/').$file_name, $data);

            $photo = new Gallery();
            $photo->photo = $file_name;
            $photo->row_id = $product->id;
            $photo->table = 'products';

            $photo->save();
        }
        
        return Response::json(array('success' => View::make('admin/products/table',array('product'=>$product))->render()));
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
    public function edit(Products $products, $product)
    {
        $product = Products::find($product);
        $product_stones = Product_stones::where('product', $product)->get();
        $models = Models::all();
        $jewels = Jewel::all();
        $prices = Price::where('type', 'sell')->get();
        $stones = Stone::all();

        $photos = Gallery::where(
            [
                ['table', '=', 'products'],
                ['row_id', '=', $product->id]
            ]
        )->get();

        return \View::make('admin/products/edit', array('photos' => $photos, 'product_stones' => $product_stones, 'product' => $product, 'jewels' => $jewels, 'models' => $models, 'prices' => $prices, 'stones' => $stones));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products, $product)
    {
        $product = Products::find($product);
        
        if($product){
            $product_stones = Product_stones::where('product', $product)->get();
            $models = Models::all();
            $jewels = Jewel::all();
            $prices = Price::where('type', 'sell')->get();
            $stones = Stone::all();
    
            $photos = Gallery::where(
                [
                    ['table', '=', 'products'],
                    ['row_id', '=', $product->id]
                ]
            )->get();

            $validator = Validator::make( $request->all(), [
                'jewelsTypes' => 'required',
                'retail_price' => 'required',
                'wholesale_prices' => 'required',
                'weight' => 'required|numeric|between:0.1,10000',
                'size' => 'required|numeric|between:0.1,10000',
                'workmanship' => 'required|numeric|between:0.1,500000',
                'price' => 'required|numeric|between:0.1,500000'
            ]); 
    
            if ($validator->fails()) {
                return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
            }

            $path = public_path('uploads/products/');
            
            File::makeDirectory($path, 0775, true, true);
    
            $file_data = $request->input('images'); 
            foreach($file_data as $img){
                $file_name = 'productimage_'.uniqid().time().'.png';
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                file_put_contents(public_path('uploads/products/').$file_name, $data);
    
                $photo = new Gallery();
                $photo->photo = $file_name;
                $photo->row_id = $product->id;
                $photo->table = 'products';
    
                $photo->save();
            }
    
            $product->model = $request->model;
            $product->jewel_type = $request->jewelsTypes;
            $product->weight = $request->weight;
            $product->retail_price = $request->retail_price;
            $product->wholesale_price  = $request->wholesale_prices;
            $product->size = $request->size;
            $product->workmanship = $request->workmanship;
            $product->price = $request->price;
    
            if($request->for_wholesale == false){
                $product->for_wholesale = 'no';
            } else{
                $product->for_wholesale = 'yes';
            }
    
            $product->save();

            $deleteStones = Product_stones::where('product', $product->id)->delete();
    
            foreach($request->stones as $key => $stone){
                if($stone) {
                    $product_stones = new Product_stones();
                    $product_stones->product = $product->id;
                    $product_stones->model = $request->model;
                    $product_stones->stone = $stone;
                    $product_stones->amount = $request->stone_amount[$key];
                    $product_stones->save();
                }
            }

            $product_photos = Gallery::where(
                [
                    ['table', '=', 'products'],
                    ['row_id', '=', $product->id]
                ]
            )->get();
    
            $photosHtml = '';
            
            foreach($product_photos as $photo){
                $photosHtml .= '
                    <div class="image-wrapper">
                    <div class="close"><span data-url="gallery/delete/'.$photo->id.'">&#215;</span></div>
                    <img src="'.asset("uploads/products/" . $photo->photo).'" alt="" class="img-responsive" />
                </div>';
            }

            return Response::json(array('table' => View::make('admin/products/table',array('product' => $product))->render(), 'photos' => $photosHtml, 'ID' => $product->id));
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products, $product)
    {
        $product = Products::find($product);
        
        if($product){
            $product->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
