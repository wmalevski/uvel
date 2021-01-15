<?php

namespace App\Http\Controllers\Store;
use Auth;
use Cart;
use App\Product;
use App\Jewel;
use App\Material;
use App\MaterialType;
use App\ProductOtherType;
use App\Slider;
use App\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blog;
use Response;

class StoreController extends BaseController{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$products = Product::where(array(
			array('status', '=', 'available')
		))->get();

		$models = Model::all();
		$productothertypes = ProductOtherType::all();
		$materials = Material::get()->groupBy('parent_id');
		$jewels = Jewel::all();
		$articles = Blog::take(3)->get();
		// $slides = Slider::all(); // No longer wanted

		foreach($materials as $collect){
			foreach($collect as $material){
				foreach($material->productsOnline->take(10) as $key=>$product){
					$product->weight = calculate_product_weight($product);
				}
			}
		}

		return \View::make('store.pages.index', array(
			'products' => $products,
			'jewels' => $jewels,
			'articles' => $articles,
			'materials' => $materials,
			'productothertypes' => $productothertypes,
			// 'slides' => $slides, // No longer wanted
			'models' => $models
		));
	}

	public function search(Request $request){
		$products = Product::where(array(
			array('status','available'),
			array('website_visible','yes'),
			array('store_id', '!=', 1)
		))->where(function($query) use ($request){
			$query
				->where('id',$request->term)
				->orWhere('name',$request->term);
		});

		// When only one product is found, go directly to the product page
		if($products->count() == 1){
			$product = $products->get()[0]->id;
			$return = array('go_to_page'=>'/online/products/'.$product);
		}
		elseif($products->count() > 1){
			// For more than 1 result, the search was most likely for a Jewel Name
			$jewels = Jewel::select('id')->where(array(array('name',$request->term)));
			if($jewels->count() == 1 ){
				$jewel = $jewels->get()[0]->id;
				$return = array('go_to_page'=>'/online/products?byJewel[]='.$jewel.'&listType=goGrid');
			}
			else{
				// For some reason there's more than one Jewel with the searched name
				$return = array(
					'products'=>$products->get(),
					'jewels'=>$jewels->get()
				);
			}
		}
		else{
			// Returning no results
			$return = array();
		}

		return Response::json($return, 200);

	}
}