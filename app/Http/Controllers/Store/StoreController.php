<?php

namespace App\Http\Controllers\Store;
use Auth;
use Cart;
use App\Product;
use App\Jewel;
use App\Material;
use App\MaterialType;
use App\ProductOtherType;
use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blog;;

class StoreController extends BaseController
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

        $productothertypes = ProductOtherType::all();

        $materialsTypes = MaterialType::all();

        $jewels = Jewel::all();

        $articles = Blog::take(3)->get();

        $slides = Slider::all();
        //dd($productothertypes);

        return \View::make('store.pages.index', array('products' => $products, 'jewels' => $jewels, 'articles' => $articles, 'materialTypes' => $materialsTypes, 'productothertypes' => $productothertypes, 'slides' => $slides));
    }

}
