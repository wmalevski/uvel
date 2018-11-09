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
    public function index()
    {
        $products = ProductOther::where([
            ['quantity', '!=', 0]
        ])->paginate(12);

        $stores = Store::all()->except(1);

        $productothertypes = ProductOtherType::all();

        $materials = Material::all();

        $materialTypes = MaterialType::all();

        $jewels = Jewel::all();

        return \View::make('store.pages.productsothers.index', array('products' => $products, 'stores' => $stores, 'materials' => $materials, 'jewels' => $jewels, 'productothertypes' => $productothertypes, 'materialTypes' => $materialTypes));
    }

    public function show(ProductOther $product){
        $productothertypes = ProductOtherType::all();

        $products = ProductOther::paginate(12);

        $materialTypes = MaterialType::all();

        $allProducts = ProductOther::select('*')->where('type_id',$product->type_id )->whereNotIn('id', [$product->id]);
        $similarProducts = $allProducts->orderBy(DB::raw('ABS(`price` - '.$product->price.')'))->take(5)->get();
        
        if($product){
            return \View::make('store.pages.productsothers.single', array('productothertypes' => $productothertypes, 'materialTypes' => $materialTypes, 'product' => $product, 'products' => $products, 'similarProducts' => $similarProducts, 'productAvgRating' => $product->getSimilarProductAvgRating($product)));
        }
    }

    public function filter(Request $request){
        $query = ProductOther::select('*');

        if ($request->priceFrom && $request->priceTo) {
            $query = $query->whereBetween('price', [$request->priceFrom, $request->priceTo]);
        } else if($request->priceFrom){
            $query = $query->where('price', '>=', $request->priceFrom);
        } else if($request->priceTo){
            $query = $query->where('price', '<=', $request->priceTo);
        }

        if ($request->byType) {
            $query = $query->whereIn('type_id', $request->byType);
        }

        if ($request->size) {
            $query = $query->whereIn('size', $request->size);
        }

        if ($request->size) {
            $query = $query->whereIn('size', $request->size);
        }

        if ($request->byStore) {
            $query = $query->whereIn('store_id', $request->byStore);
        }

        if ($request->byJewel) {
            $query = $query->whereIn('jewel_id', $request->byJewel);
        }

        if ($request->byMaterial) {
            $query = $query->whereIn('material_id', $request->byMaterial);
        }

        $products = $query->where('status', 'available')->orderBy('id', 'desc')->get();

        print_r(count($products));
        echo '<pre>'; print_r($products); echo '</pre>';
    }

    public function quickView($barcode)
    {
        $type = '';
        $product = Product::where('barcode', $barcode)->first();
        $productBox = ProductOther::where('barcode', $barcode)->first();

        if($product){
            $type = 'product';
        }else{
            $type = 'productBox';
            $product = $productBox;
        }

        if($product){
            return \View::make('store/pages/products/quickview', array('product' => $product ,'type' => $type));
        }
    }

}
