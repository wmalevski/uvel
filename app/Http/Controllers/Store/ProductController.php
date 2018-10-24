<?php

namespace App\Http\Controllers\Store;
use App\Product;
use App\Store;
use App\Material;
use App\Jewel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
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
        ])->paginate(12);

        $stores = Store::all()->except(1);

        $materials = Material::all();

        $jewels = Jewel::all();

        return \View::make('store.pages.products.index', array('products' => $products, 'stores' => $stores, 'materials' => $materials, 'jewels' => $jewels));
    }

    public function show(Product $product){
        $products = Product::where([
            ['status', '=', 'available']
        ])->paginate(12);

        if($product){
            return \View::make('store.pages.products.single', array('product' => $product, 'products' => $products));
        }
    }

    public function filter(Request $request){
        $query = Product::select('*');

        if ($request->byStore) {
            foreach($request->byStore as $store){
                $query = $query->where('store_id', $store);
            }
        }

        if ($request->byJewel) {
            $query = $query->where('jewel_id', $request->byJewel);
        }

        if ($request->byMaterial) {
            $query = $query->where('material_id', $request->byMaterial);
        }

        $products = $query->where('status', 'available')->orderBy('id', 'desc')->get();

        print_r(count($products));
        echo '<pre>'; print_r($products); echo '</pre>';
    }

}
