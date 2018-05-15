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
            'name' => 'required|unique:products_others,name',
            'type' => 'required',
            'price' => 'required|numeric|between:0.1,10000',
            'quantity' => 'required|numeric|between:1,10000'
        ]); 

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        //$product = Products_others::create($request->all());

        $product = Products_others::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        $product->code = 'B'.unique_random('products_others', 'code', 7);
        $bar = '380'.unique_number('products_others', 'barcode', 7).'2'; 

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
    public function edit(Products_others $products_others, $product)
    {
        $product = Products_others::find($product);
        $types = Products_others_types::all();

        return \View::make('admin/products_others/edit', array('product' => $product, 'types' => $types));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products_others  $products_others
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products_others $products_others, $product)
    {
        $product = Products_others::find($product);
        
        $product->name = $request->name;
        $product->type = $request->type;
        $product->price = $request->price;

        //$product->quantity = $request->quantity;

        if($request->quantity_action == 'add'){
            $product->quantity = $request->quantity+$request->quantity_after;
        } else if($request->quantity_action == 'remove'){
            $product->quantity = $request->quantity-$request->quantity_after;
        }

        $validator = Validator::make( $request->all(), [
            'name' => 'required|unique:products_others,name',
            'type' => 'required',
            'price' => 'required|numeric|between:0.1,10000',
            'quantity' => 'required|numeric|between:1,10000'
        ]); 

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }
        
        $product->save();
        
        return Response::json(array('table' => View::make('admin/products_others/table',array('product'=>$product))->render(), 'ID' => $product->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products_others  $products_others
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products_others $products_others, $product)
    {
        $product = Products_others::find($product);
        
        if($product){
            $product->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
