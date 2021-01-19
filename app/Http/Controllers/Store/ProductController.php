<?php

namespace App\Http\Controllers\Store;
use App\Product;
use App\ProductOtherType;
use App\Store;
use App\Material;
use App\MaterialType;
use App\Jewel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Session;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $products = Product::filterProducts($request)->where([
            ['status', '=', 'available'],
            ['website_visible', '=', 'yes'],
            ['store_id', '!=', 1]
        ])->paginate(\App\Setting::where('key','per_page')->get()[0]->value);

        Session::put('products_active_filters', $request->fullUrl() );

        $stores = Store::all()->except(1);

        $productothertypes = ProductOtherType::all();

        $materials = Material::all();

        $materialTypes = MaterialType::all();

        $jewels = Jewel::all();

        // $count = 0;
        foreach ($products as $product) {
            // if ($count < 2) {
                $product->weight = calculate_product_weight($product);
            // }
            // $count++;
        }

        return \View::make('store.pages.products.index', array('products' => $products, 'stores' => $stores, 'materials' => $materials, 'jewels' => $jewels, 'productothertypes' => $productothertypes, 'materialTypes' => $materialTypes));
    }

    public function show(Product $product){

        $products = Product::where([
            ['status', '=', 'available'],
            ['store_id', '!=', 1]
        ])->paginate(\App\Setting::where('key','per_page')->get()[0]->value);

        $materialTypes = MaterialType::all();

        $allProducts = Product::select('*')->where('jewel_id',$product->jewel_id )->whereNotIn('id', [$product->id]);
        $similarProducts = $allProducts->where('status', 'available')->orderBy(DB::raw('ABS(`price` - '.$product->price.')'))->take(5)->get();

        if($product) {
            $weightWithoutStone = $product->weight;
            $product->weight = calculate_product_weight($product);
            foreach ($similarProducts as $similarProduct){
                $similarProduct->weight = calculate_product_weight($similarProduct);
            }

            return \View::make('store.pages.products.single', array( 'weightWithoutStone' => $weightWithoutStone, 'materialTypes' => $materialTypes, 'product' => $product, 'products' => $products, 'similarProducts' => $similarProducts, 'productAvgRating' => $product->getProductAvgRating($product)));
        }
    }

    public function filter(Request $request){
        $products = Product::filterProducts($request)->where([
            ['status', '=', 'available'],
            ['website_visible', '=', 'yes'],
            ['store_id', '!=', 1]
        ])->orderBy('id', 'DESC')->paginate(\App\Setting::where('key','per_page')->get()[0]->value);


        $response = '';
        $count = 0;
        foreach($products as $product){
            if ($count < 2) {
                $product->weight = calculate_product_weight($product);
            }
            $count++;
            $response .= \View::make('store/pages/products/ajax', array('product' => $product, 'listType' => $request->listType));
        }

        $products->setPath('');
        $response .= $products->appends(Input::except('page'))->links();

        return $response;
    }

    public function quickView(Product $product)
    {
        if($product){
            $product->weight = calculate_product_weight($product);

            return \View::make('store/pages/products/quickview', array('product' => $product));
        }
    }
}
