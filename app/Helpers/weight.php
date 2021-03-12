<?php

use App\Stone;
use App\Nomenclature;
use App\ProductStone;
use Illuminate\Support\Str;

if(!function_exists('calculate_product_weight')){
	function calculate_product_weight($product){
		$weight = round($product->weight, 3);
		$weightStoneData = array();

		if($product->stones->first()&&($stone=Stone::where('id', $product->stones->first()->stone_id)->first())){
			$checkMaterial=false;
			if(Str::lower($product->material->name)=="сребро"){
				$checkMaterial=true;
			}
			$stoneAbb=array();
			foreach($product->stones as $productStone){
				$stoneId=$productStone->stone_id;
				$stoneName=Nomenclature::where('id', $productStone->stone()->first()->nomenclature_id)->first()->name;
				$stoneWeight=$productStone->weight;

				$weight=round($product->weight, 3);
				if($product->weight_without_stones=='no' && $checkMaterial){
					$weight=round($product->gross_weight, 3);
				}

				if(Stone::where('id', $stoneId)->first()->type!==1){
					if(!$checkMaterial){
						$stoneCarat = Stone::where('id', $stoneId)->first()->carat;
						$stoneAbb[] = $stoneName . ' ' . $stoneCarat . 'кт.';
					}
					else{
						$stoneAbb[] = $stoneName;
					}
				}
				else{
					if(!$checkMaterial){
						$stoneAbb[] = $stoneName . ' ' . $stoneWeight . 'гр.';
					}
					else{
						$stoneAbb[] = $stoneName;
					}
				}
			}
		}

		$weightStoneData['weight'] = $weight;
		if(isset($stoneAbb)){
			$weightStoneData['stone'] = $stoneAbb;
		}

		return $weightStoneData;
	}
}

if(!function_exists('calculate_model_weight')){
	function calculate_model_weight($model){
		$weight = round($model->weight, 3);
		$weightStoneData = array();

		if($model->stones->first()&&($stone=Stone::where('id', $model->stones->first()->stone_id)->first())){
			$checkMaterial=false;
			foreach($model->materials() as $material){
				if(Str::lower($material->name)=="сребро"){
					$checkMaterial = true;
				}
			};
			$stoneAbb=array();
			foreach($model->stones as $productStone){
				$stoneId=$productStone->stone_id;
				$stoneName=Nomenclature::where('id', $productStone->stone()->first()->nomenclature_id)->first()->name;
				$stoneWeight=$productStone->weight;

				$weight=round($model->weight, 3);
				if(Stone::where('id', $stoneId)->first()->type!==1){
					if(!$checkMaterial){
						$stoneCarat = Stone::where('id', $stoneId)->first()->carat;
						$stoneAbb[] = $stoneName . ' ' . $stoneCarat . 'кт.';
					}
					else{
						$stoneAbb[] = $stoneName;
					}
				}
				else{
					if(!$checkMaterial){
						$stoneAbb[] = $stoneName . ' ' . $stoneWeight . 'гр.';
					}
					else{
						$stoneAbb[] = $stoneName;
					}
				}
			}
		}

		$weightStoneData['weight'] = $weight;
		if(isset($stoneAbb)){
			$weightStoneData['stone'] = $stoneAbb;
		}

		return $weightStoneData;
	}
}