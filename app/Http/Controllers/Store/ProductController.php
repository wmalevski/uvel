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
use Illuminate\Support\Facades\Input;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::where([
            ['status', '=', 'available'],
            ['website_visible', '=', 'yes']
        ])->paginate(env('RESULTS_PER_PAGE'));

        $products_new = new Product();
        $products = $products_new->filterProducts($request, $products);

        $products = $products->where([
            ['status', '=', 'available'],
            ['website_visible', '=', 'yes']
        ])->paginate(env('RESULTS_PER_PAGE'));

        $stores = Store::all()->except(1);

        $productothertypes = ProductOtherType::all();

        $materials = Material::all();

        $materialTypes = MaterialType::all();

        $jewels = Jewel::all();

        foreach ($products as $product) {
            $product->weight = calculate_product_weight($product);
        }

        return \View::make('store.pages.products.index', array('products' => $products, 'stores' => $stores, 'materials' => $materials, 'jewels' => $jewels, 'productothertypes' => $productothertypes, 'materialTypes' => $materialTypes));
    }

    public function show(Product $product){

        $products = Product::where([
            ['status', '=', 'available']
        ])->paginate(env('RESULTS_PER_PAGE'));

        $materialTypes = MaterialType::all();

        $allProducts = Product::select('*')->where('jewel_id',$product->jewel_id )->whereNotIn('id', [$product->id]);
        $similarProducts = $allProducts->orderBy(DB::raw('ABS(`price` - '.$product->price.')'))->take(5)->get();
        
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
        $query = Product::select('*');

        $products_new = new Product();
        $products = $products_new->filterProducts($request, $query);
        $products = $products->where([
            ['status', '=', 'available'],
            ['website_visible', '=', 'yes']
        ])->orderBy('id', 'DESC')->paginate(env('RESULTS_PER_PAGE'));


        $response = '';
        foreach($products as $product){
            $product->weight = calculate_product_weight($product);
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
