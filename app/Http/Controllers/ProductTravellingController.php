<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\ProductTravelling;
use App\Product;
use App\Store;
use Response;
use Redirect;
use Auth;

class ProductTravellingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $travelling = ProductTravelling::all();
        $stores = Store::all();

        return \View::make('admin/products_travelling/index', array('products' => $products, 'travelling' => $travelling, 'stores' => $stores));
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
            'product_id' => 'required',
            'store_to_id' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $check = Product::find($request->product_id);

        if($check){
            if($check->store_id == $request->store_to_id){
                return Response::json(['errors' => array('quantity' => ['Не може да изпращате материал към същият магазин'])], 401);
            }
        }

        $travel = new ProductTravelling();
        $travel->product_id = $request->product_id;
        $travel->store_from_id = Auth::user()->getStore()->id;
        $travel->store_to_id  = $request->store_to_id;
        $travel->date_sent = new \DateTime();
        $travel->user_sent = Auth::user()->getId();

        $travel->save();

        $product = Product::find($request->product_id);
        $product->status = 'travelling';
        $product->save();


        // $history = new History();

        // $history->action = '1';
        // $history->user = Auth::user()->getId();
        // $history->table = 'products_travelling';
        // $history->result_id = $travel->id;

        // $history->save();

        return Response::json(array('success' => View::make('admin/products_travelling/table', array('product' => $travel, 'proID' => $travel->id))->render()));
    }

    public function accept($product){
        $travel = ProductTravelling::findOrFail($product);
        $product = Product::find($travel->product_id);

        if($product->status == 0){

            $travel->status = '1';
            $travel->date_received = new \DateTime();
            $travel->save();

            $product->store_id = $travel->store_to_id;
            $product->status = 'available';
            $product->save();

            return Redirect::back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductTravelling  $productTravelling
     * @return \Illuminate\Http\Response
     */
    public function show(ProductTravelling $productTravelling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductTravelling  $productTravelling
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductTravelling $productTravelling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductTravelling  $productTravelling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductTravelling $productTravelling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductTravelling  $productTravelling
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductTravelling $product)
    {
        if($product){
            $originProduct = Product::find($product->product_id);
            $originProduct->status = 'available';
            $originProduct->save();

            $product->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
