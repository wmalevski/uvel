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
			'latest_by_materials' => StoreController::Latest_By_Materials(),
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

	public static function Latest_By_Materials(){
		$html = '';

		foreach(Material::get()->groupBy('parent_id') as $collection){
			$toAdd = false;
			$append = '<div class="home-feature"><div class="container"><div class="group_featured_products row"><div class="col-md-24"><div class="home_fp"><h6 class="general-title">Последни от '.$collection->first()->name.'</h6><div class="home_fp_wrapper"><div class="home_fp2">';

			foreach($collection as $material){
				// Show only materials with items in them
				if($material->productsOnline->count() > 0){
					$toAdd = true;
					// Get 12 items at most per material
					// The ordering by `created_at` DESC is done in App\Material::productsOnline()
					foreach($material->productsOnline->take(12) as $key=>$product){
						// Don't show items from storage
						if(strtolower($product->store_info->name)!=='склад'){

							$imageSrc = asset('store/images/demo_375x375.png');
							if(count($product->photos) && isset($product->photos->first()['photo']) ){
								$imageSrc = asset("uploads/products/" . $product->photos->first()['photo']);
							}
							elseif(count($product->model->photos) && isset($product->model->photos->first()['photo'])){
								$imageSrc = asset("uploads/models/" . $product->model->photos->first()['photo']);
							}


							$append .= '<li class="element no_full_width" data-alpha="'.$product->name.'" data-price="'.$product->price.'" data-id="'.$product->id.'"><ul class="row-container list-unstyled clearfix"><li class="row-left"><a href="'.route('single_product', array('product' => $product->id)).'" class="container_item"><img  class="img-fill" class="img-zoom img-responsive image-fly" alt="'.$product->name.'" src="'.$imageSrc.'" ></a><div class="hbw"><span class="hoverBorderWrapper"></span></div></li><li class="row-right parent-fly animMix"><div class="product-content-left"><a class="title-5" href="'.route('single_product', array('product' => $product->id)).'">No: '.implode(" ", str_split($product->id, 3)).'</a><br>Модел: '.$product->model->name.'<br>'.$product->material->name.' - '.$product->material->code.' - '.$product->material->color.'<br>'.$product->weight.' гр.<br>Налично в: '.$product->store_info->name.'<span class="spr-badge" data-rating="0.0"><span class="spr-starrating spr-badge-starrating">'.$product->listProductAvgRatingStars($product).'</span></span></div><div class="product-content-right"><div class="product-price"><span class="price">'.number_format($product->price).' лв.</span></div></div><div class="hover-appear">

<a href="'.route('single_product', array('product' => $product->id)).'" class="effect-ajax-cart product-ajax-qs" title="Преглед"><i class="fa fa-lg fa-eye"></i><span class="list-mode">Преглед</span></a>'
.
(Auth::check()?
'<button class="wish-list" title="Добави в желани" data-url="'.route('wishlists_store',array('type'=>'product','item'=>$product->id)).'"><i class="fa fa-lg fa-heart"></i><span class="list-mode">Добави в желани</span></button>'
:'')
.
'</div></li></ul></li>';
						}
					}
				}
			}

			$append .= '</div></div></div></div></div></div></div>';
			if($toAdd){
				$html .= $append;
			}
		}

		return $html;

	}
}