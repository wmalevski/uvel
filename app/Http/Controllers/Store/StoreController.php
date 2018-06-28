<?php

namespace App\Http\Controllers\Store;
use App\Products;
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
        $products = Products::where([
            ['status', '=', 'available'],
            ['for_wholesale', '=', 'no']
        ])->get();

        return \View::make('store.pages.index', array('products' => $products));
    }

}
