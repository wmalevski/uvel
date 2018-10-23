<?php

namespace App\Http\Controllers\Store;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreController extends Controller
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
        ])->get();

        return \View::make('store.pages.index', array('products' => $products));
    }

}
