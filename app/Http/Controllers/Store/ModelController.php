<?php

namespace App\Http\Controllers\Store;
use App\Model;
use App\Product;
use App\ProductOther;
use App\Store;
use App\Material;
use App\Jewel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ModelController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $models = Product::where([
        //     ['status', '=', 'available']
        // ])->paginate(12);

        $models = Model::paginate(12);

        $stores = Store::all()->except(1);

        $materials = Material::all();

        $jewels = Jewel::all();

        return \View::make('store.pages.models.index', array('models' => $models, 'stores' => $stores, 'materials' => $materials, 'jewels' => $jewels));
    }

    public function show(Model $model){
        $models = Model::paginate(12);

        $allModels = Model::select('*')->where('jewel_id',$model->jewel_id )->whereNotIn('id', [$model->id]);
        $similarModels = $allModels->orderBy(DB::raw('ABS(`price` - '.$model->price.')'))->take(5)->get();

        if($model){
            return \View::make('store.pages.models.single', array('model' => $model, 'models' => $models, 'similarModels' => $similarModels));
        }
    }

    public function filter(Request $request){
        $query = Model::select('*');

        if ($request->priceFrom && $request->priceTo) {
            $query = $query->whereBetween('price', [$request->priceFrom, $request->priceTo]);
        } else if($request->priceFrom){
            $query = $query->where('price', '>=', $request->priceFrom);
        } else if($request->priceTo){
            $query = $query->where('price', '<=', $request->priceTo);
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

        $models = $query->orderBy('id', 'desc')->get();

        print_r(count($models));
        echo '<pre>'; print_r($models); echo '</pre>';
    }

    public function quickView($barcode)
    {
        $type = '';
        $product = Product::where('barcode', $barcode)->first();
        $productBox = ProductOther::where('barcode', $barcode)->first();
        $model = ProductOther::where('barcode', $barcode)->first();

        if($product){
            $type = 'product';
        }elseif($productBox){
            $type = 'productBox';
            $product = $productBox;
        }else{
            $type = 'model';
            $product = $model;
        }

        if($product){
            return \View::make('store/pages/products/quickview', array('product' => $product ,'type' => $type));
        }
    }

}
