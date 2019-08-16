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
    public function index(Request $request)
    {
        $models = Model::where('website_visible', 'yes')->paginate(env('RESULTS_PER_PAGE'));
        $models_new = new Model();
        $models = $models_new->filterModels($request, $models);
        $models = $models->where('website_visible', 'yes')->paginate(env('RESULTS_PER_PAGE'));

        $stores = Store::all()->except(1);

        $materials = Material::all();

        $jewels = Jewel::all();

        return \View::make('store.pages.models.index', array('models' => $models, 'stores' => $stores, 'materials' => $materials, 'jewels' => $jewels));
    }

    public function show(Model $model){
        $models = Model::paginate(env('RESULTS_PER_PAGE'));

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
        $products = $products->where('website_visible', 'yes')->orderBy('id', 'DESC')->paginate(env('RESULTS_PER_PAGE'));

        $response = '';
        foreach($products as $product){
            $response .= \View::make('store/pages/models/ajax', array('model' => $product, 'listType' => $request->listType));
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
