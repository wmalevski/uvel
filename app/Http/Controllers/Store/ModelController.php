<?php

namespace App\Http\Controllers\Store;
use App\Model;
use App\Product;
use App\ProductOther;
use App\Store;
use App\Material;
use App\Jewel;
use Illuminate\Http\Request as Request;
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

        $products_new = new Model();
        $products = $products_new->filterModels($request, $query);

        $products = $query->orderBy('id', 'desc')->get();

        $response = '';
        foreach($products as $product){
            $response .= \View::make('store/pages/models/ajax', array('model' => $product));
        }

        return $response;
    }

    public function quickView(Model $model)
    {
        if($model){
            return \View::make('store/pages/models/quickview', array('model' => $model));
        }
    }

}
