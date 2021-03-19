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
use App\Setting;

class ProductOtherController extends BaseController{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $products = ProductOther::filterProducts($request);
        $products = $products->where(array(
            array('quantity','!=',0),
            array('store_id','!=',1)
        ))->orderBy('id','desc')->paginate(Setting::where('key','per_page')->first()->value);

        // $stores = Store::all()->except(1);
        // $productothertypes = ProductOtherType::all();
        // $materials = Material::all();
        // $materialTypes = MaterialType::all();
        // $jewels = Jewel::all();

        return \View::make('store.pages.productsothers.index', array('products' => $products
            // 'stores' => $stores, 'materials' => $materials, 'jewels' => $jewels, 'productothertypes' => $productothertypes, 'materialTypes' => $materialTypes
        ));
    }

    public function show(ProductOther $product){
        $productothertypes = ProductOtherType::all();
        $products = ProductOther::paginate(Setting::where('key','per_page')->first()->value);
        $materialTypes = MaterialType::all();
        $allProducts = ProductOther::where('type_id',$product->type_id)->where('store_id','!=',1)->whereNotIn('id', array($product->id));
        $similarProducts = $allProducts->orderBy(DB::raw('ABS(`price` - '.$product->price.')'))->take(5)->get();

        if($product){
            return \View::make('store.pages.productsothers.single', array('productothertypes' => $productothertypes, 'materialTypes' => $materialTypes, 'product' => $product, 'products' => $products, 'similarProducts' => $similarProducts, 'productAvgRating' => $product->getSimilarProductAvgRating($product)));
        }
    }

    public function filter(Request $request){
        $products = ProductOther::filterProducts($request)->where(array(
            array('quantity','!=',0),
            array('store_id','!=',1)
        ))->orderBy('id', 'DESC')->paginate(Setting::where('key','per_page')->first()->value);

        $response = '';
        foreach($products as $product){
            $response .= \View::make('store/pages/productsothers/ajax', array('product' => $product, 'listType' => $request->listType));
        }

        return $response;
    }

    public function quickView(ProductOther $product){
        if($product){
            return \View::make('store/pages/productsothers/quickview', array('product' => $product));
        }
    }

}