<?php

namespace App\Http\Controllers\Store;
use App\ProductOther;
use App\ProductOtherType;
use App\Store;
use App\Material;
use App\MaterialType;
use App\Jewel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductOtherController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = ProductOther::filterProducts($request);

        $products = $products->where([
            ['quantity', '!=', 0],
            ['store_id', '!=', 1]
        ])->paginate(\App\Setting::where('key','per_page')->get()[0]->value);

        $stores = Store::all()->except(1);

        $productothertypes = ProductOtherType::all();

        $materials = Material::all();

        $materialTypes = MaterialType::all();

        $jewels = Jewel::all();

        return \View::make('store.pages.productsothers.index', array('products' => $products, 'stores' => $stores, 'materials' => $materials, 'jewels' => $jewels, 'productothertypes' => $productothertypes, 'materialTypes' => $materialTypes));
    }

    public function show(ProductOther $product){
        $productothertypes = ProductOtherType::all();

        $products = ProductOther::paginate(\App\Setting::where('key','per_page')->get()[0]->value);

        $materialTypes = MaterialType::all();

        $allProducts = ProductOther::select('*')->where('type_id',$product->type_id )->where('store_id','!=', 1)->whereNotIn('id', [$product->id]);
        $similarProducts = $allProducts->orderBy(DB::raw('ABS(`price` - '.$product->price.')'))->take(5)->get();

        if($product){
            return \View::make('store.pages.productsothers.single', array('productothertypes' => $productothertypes, 'materialTypes' => $materialTypes, 'product' => $product, 'products' => $products, 'similarProducts' => $similarProducts, 'productAvgRating' => $product->getSimilarProductAvgRating($product)));
        }
    }

    public function filter(Request $request){
        $products = ProductOther::filterProducts($request)->where([
            ['quantity', '!=', 0],
            ['store_id', '!=', 1]
        ])->orderBy('id', 'DESC')->paginate(\App\Setting::where('key','per_page')->get()[0]->value);

        $response = '';
        foreach($products as $product){
            $response .= \View::make('store/pages/productsothers/ajax', array('product' => $product, 'listType' => $request->listType));
        }

        return $response;

    }

    public function quickView(ProductOther $product)
    {
        if($product){
            return \View::make('store/pages/productsothers/quickview', array('product' => $product));
        }
    }

}
