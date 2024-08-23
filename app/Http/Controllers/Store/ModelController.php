<?php

namespace App\Http\Controllers\Store;
use App\Model;
use App\Product;
use App\ProductOther;
use App\Store;
use App\Material;
use App\Jewel;
use App\Setting;
use Illuminate\Http\Request as Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ModelController extends BaseController{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request){
		$models = new Model();
		$models = $models->filterModels($request, $models)->where('website_visible', 'yes')->orderBy('id','desc')->paginate(Setting::where('key','per_page')->first()->value);

		Session::put('models_active_filters', $request->fullUrl());

		$stores = Store::all()->except(1);
		$materials = Material::all();
		$jewels = Jewel::all();

		return \View::make('store.pages.models.index', array(
			'models' => $models,
			'stores' => $stores,
			'materials' => $materials,
			'jewels' => $jewels
		));
	}

	public function show(Model $model){
		$models = Model::paginate(Setting::where('key','per_page')->first()->value);

		$allModels = Model::where(array(
			array('website_visible','yes'),
			array('jewel_id',$model->jewel_id)
		))->whereNotIn('id',array($model->id));
		$similarModels = $allModels->orderBy(DB::raw('ABS(`price` - '.$model->price.')'))->take(5)->get();

		if($model){
			return \View::make('store.pages.models.single', array(
				'model' => $model,
				'models' => $models,
				'similarModels' => $similarModels
			));
		}
	}

	public function filter(Request $request){
		$products_new = new Model();
		$products = $products_new->filterModels($request, Model::all());
		$products = $products->where('website_visible', 'yes')->orderBy('id', 'DESC')->paginate(Setting::where('key','per_page')->first()->value);
		$response = '';
		foreach($products as $product){
			$response .= \View::make('store/pages/models/ajax', array(
				'model' => $product,
				'listType' => $request->listType
			));
		}
		return $response;
	}

	public function quickView(Model $model){
		if($model){
			return \View::make('store/pages/models/quickview', array('model' => $model));
		}
	}

}
