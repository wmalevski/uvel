<?php

namespace App\Http\Controllers\Store;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where([
            ['status', '=', 'available']
        ])->paginate(12);

        return \View::make('store.pages.products.index', array('products' => $products));
    }

    public function show(Product $product){
        $products = Product::where([
            ['status', '=', 'available']
        ])->paginate(12);

        if($product){
            return \View::make('store.pages.products.single', array('product' => $product, 'products' => $products));
        }
    }

}
