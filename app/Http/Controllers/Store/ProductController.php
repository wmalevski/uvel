<?php

namespace App\Http\Controllers\Store;
use App\Product;
use App\Store;
use App\Material;
use App\Jewel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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

        $allProducts = Product::select('*')->where('jewel_id',$product->jewel_id )->whereNotIn('id', [$product->id]);
        $similarProducts = $allProducts->orderBy(DB::raw('ABS(`price` - '.$product->price.')'))->take(5)->get();

        if($product){
            return \View::make('store.pages.products.single', array('product' => $product, 'products' => $products, 'similarProducts' => $similarProducts));
        }
    }

    public function filter(Request $request){
        $query = Product::select('*');

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

}
