<?php

namespace App\Helpers;

use App\Jewel;
use App\Material;
use App\MaterialType;
use App\ProductOtherType;

class StoreNav{

	private static $jewel,$material,$material_types=array();

	public function __construct(){
		$j = Jewel::where('deleted_at',NULL)->take(1)->get();
		StoreNav::$jewel = ( is_object($j) && isset($j[0]) && isset($j[0]->id) ? $j[0]->id : null );

		$mt = MaterialType::where(array(
			'deleted_at'=>NULL,
			'site_navigation'=>'yes'
		))->get();
		foreach ($mt as $k=>$v){
			array_push(StoreNav::$material_types,array(
				'id'=>$v->id,
				'name'=>$v->name
			));
		}

		if(!empty(StoreNav::$material_types)){
			$first_material = StoreNav::$material_types[0]['id'];
			$m = Material::where('parent_id', $first_material )->take(1)->get();
			StoreNav::$material = ( is_object($m) && isset($m[0]) && isset($m[0]->id) ? $m[0]->id : null );
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

		echo '<a href="'.$mainLink.'" class="dropdown-toggle dropdown-link" data-toggle="dropdown"><span>Налични Бижута</span><i class="fa fa-caret-down"></i><i class="sub-dropdown1 visible-sm visible-md visible-lg"></i><i class="sub-dropdown visible-sm visible-md visible-lg"></i></a><ul class="dropdown-menu" style="display: none;">'.$subNav.'</ul>';

	}

	public static function nav_catalogue_by_model(){
		echo '<a href="'.route('models').'?byJewel[]='.StoreNav::$jewel.'&listType=goGrid"><span>По поръчка</span></a>';
	}
}