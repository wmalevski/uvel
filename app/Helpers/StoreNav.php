<?php

namespace App\Helpers;

use App\Jewel;
use App\Material;
use App\MaterialType;
use App\ProductOtherType;
use App\Store;

class StoreNav{

	private static $jewel=null;
	private static $jewel_model=null;
	private static $material=null;
	private static $material_types=array();

	public function __construct(){
		foreach(Jewel::where('deleted_at',NULL)->get() as $jewel){
			// Get the first filter with products in it for Products and Models and set it
			// Don't break the loop so both can be set
			if(StoreNav::$jewel==null && count($jewel->productsOnline)>0){
				StoreNav::$jewel=$jewel->id;
			}
			if(StoreNav::$jewel_model==null && count($jewel->models)>0){
				StoreNav::$jewel_model=$jewel->id;
			}
		}

		// Set MaterialTypes so they can be quickly reused later
		foreach(MaterialType::where(array('deleted_at'=>NULL,'site_navigation'=>'yes'))->get() as $k=>$v){
			array_push(StoreNav::$material_types,array(
				'id'=>$v->id,
				'name'=>$v->name
			));
		}

		if(!empty(StoreNav::$material_types)){
			$first_material = StoreNav::$material_types[0]['id'];
			foreach(Material::where('parent_id', $first_material)->get() as $material){
				// Get the first material with products in it, set it, and break the loop
				if(count($material->productsOnline)>0){
					StoreNav::$material = $material->id;
					break;
				}
			}
		}
	}

	public static function nav_catalogue(){
		$mainLink = route('products');
		$params = false;

		if(StoreNav::$jewel !== null){
			$params = 'byJewel[]='.StoreNav::$jewel;
		}

		if(StoreNav::$material !== null){
			$params = ( $params !== false ? $params.'&' : $params );
			$params .= 'byMaterial[]='.StoreNav::$material;
		}

		$mainLink = $mainLink . ( $params !== false ? '?'.$params.'&' : '?' ) . 'listType=goGrid';

		$subNav = '';

		if(!empty(StoreNav::$material_types)){

			// Material Types
			foreach(StoreNav::$material_types as $k=>$mt){
				$params = false;
				if(StoreNav::$jewel !== null){
					$params = 'byJewel[]='.StoreNav::$jewel;
				}

				$prefix =' <li class="'.filter_products('byMaterial', $mt['id']).'"><a tabindex="-1" href="'.route('products');

				$mat = Material::where('parent_id', $mt['id'])->take(1)->get();
				if( is_object($mat) && isset($mat[0]) && isset($mat[0]->id) ){
					$params = ( $params !== false ? $params.'&' : $params );
					$params .= 'byMaterial[]='.$mat[0]->id;
				}
				else{
					// If there is no material for this type, we don't want the item in the nav
					continue;
				}

				$suffix = 'listType=goGrid">'.$mt['name'].'</a></li>';

				$subNav .= $prefix . ( $params !== false ? '?' . $params . '&' : '?' ) . $suffix;
			}

			// Other product types
			$other_product_type = ProductOtherType::all();
			if($other_product_type->count()>0){
				foreach($other_product_type as $type){
					if(isset($type->id)&&isset($type->name)){
						$subNav .= '<li><a tabindex="-1" href="'.route('productsothers').'?byType[]='.$type->id.'">'.$type->name.'</a></li>';
					}
				}
			}

		}

		return '<a href="'.$mainLink.'" class="dropdown-toggle dropdown-link" data-toggle="dropdown"><span>Налични Бижута</span><i class="fa fa-caret-down"></i><i class="sub-dropdown1 visible-sm visible-md visible-lg"></i><i class="sub-dropdown visible-sm visible-md visible-lg"></i></a><ul class="dropdown-menu" style="display: none;">'.$subNav.'</ul>';
	}

	public static function nav_catalogue_by_model(){
		return '<a href="'.route('models').'?byJewel[]='.StoreNav::$jewel_model.'&listType=goGrid"><span>По поръчка</span></a>';
	}

	public static function jewelsFilters($type = null){
		$type = ($type ? $type : 'productsOnline');
		$output = '';
		foreach(Jewel::all() as $jewel){
			$productsCount = count($jewel->$type);
			if($productsCount > 0){
				$output .= '<li class="'.filter_products('byJewel',$jewel->id).'"><a href="#" data-id="byJewel[]='.$jewel->id.'"><span class="fe-checkbox"></span>'.$jewel->name.' ['.$productsCount.']</a></li>';
			}
		}
		return $output;
	}
	public static function materialFilters(){
		$output = '';
		foreach(Material::all() as $material){
			$productCount = count($material->productsOnline);
			if($productCount > 0){
				$output .= '<li class="'.filter_products('byMaterial', $material->id).'"><a href="#" data-id="byMaterial[]='.$material->id.'"><span class="fe-checkbox"></span>'.$material->parent->name.'-'.$material->code.' ('.$material->color.') ['.$productCount.']</a></li>';
			}
		}
		return $output;
	}
	public static function storeFilters($type = 'Online'){
		$output = '';
		$type = 'products'.$type;
		foreach(Store::all()->except(1) as $store){
			$productCount = count($store->$type);
			if($productCount > 0){
				$output .= '<li class="'.filter_products('byStore', $store->id).'"><a data-id="byStore[]='.$store->id.'" href="#"><span class="fe-checkbox"></span>'.$store->name.' ['.$productCount.']</a></li>';
			}
		}
		return $output;
	}
}