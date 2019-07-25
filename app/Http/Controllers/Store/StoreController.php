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
use App\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blog;

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

        $models = Model::all();

        $productothertypes = ProductOtherType::all();

        $materials = Material::get()->groupBy('parent_id');

        $jewels = Jewel::all();

        $articles = Blog::take(3)->get();

        $slides = Slider::all();

        foreach($materials as $collect) {
            foreach($collect as $material) {
                foreach ($material->productsOnline->take(10) as $key => $product) {
                    $product->weight = calculate_product_weight($product);
                }
            }
        }

        return \View::make('store.pages.index', array('products' => $products, 'jewels' => $jewels, 'articles' => $articles, 'materials' => $materials, 'productothertypes' => $productothertypes, 'slides' => $slides, 'models' => $models));
    }

}
