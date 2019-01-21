<?php

namespace App\Http\Controllers\Store;
use App\Product;
use App\ProductOther;
use App\ProductOtherType;
use App\Store;
use App\Material;
use App\MaterialType;
use App\Jewel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Http\Controllers\Store\ProductOtherController;

class ProductOtherController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = ProductOther::where([
            ['quantity', '!=', 0]
        ])->paginate(env('RESULTS_PER_PAGE'));

        $products_new = new ProductOther();
        $products = $products_new->filterProducts($request, $products);

        $stores = Store::all()->except(1);

        $productothertypes = ProductOtherType::all();

        $materials = Material::all();

        $materialTypes = MaterialType::all();

        $jewels = Jewel::all();

        return \View::make('store.pages.productsothers.index', array('products' => $products, 'stores' => $stores, 'materials' => $materials, 'jewels' => $jewels, 'productothertypes' => $productothertypes, 'materialTypes' => $materialTypes));
    }

    public function show(ProductOther $product){
        $productothertypes = ProductOtherType::all();

        $products = ProductOther::paginate(env('RESULTS_PER_PAGE'));

        $materialTypes = MaterialType::all();

        $allProducts = ProductOther::select('*')->where('type_id',$product->type_id )->whereNotIn('id', [$product->id]);
        $similarProducts = $allProducts->orderBy(DB::raw('ABS(`price` - '.$product->price.')'))->take(5)->get();
        
        if($product){
            return \View::make('store.pages.productsothers.single', array('productothertypes' => $productothertypes, 'materialTypes' => $materialTypes, 'product' => $product, 'products' => $products, 'similarProducts' => $similarProducts, 'productAvgRating' => $product->getSimilarProductAvgRating($product)));
        }
    }

    public function filter(Request $request){
        $query = ProductOther::select('*');

        $products_new = new ProductOther();
        $products = $products_new->filterProducts($request, $query);

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
