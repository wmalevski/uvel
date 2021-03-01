<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Material;
use App\ProductOther;
use App\Stone;
use App\Nomenclature;

class GenerateLabelController extends Controller{

	public function generate($barcode){

		$product = Product::where('barcode', $barcode)->first();
		if($product){
			$weight = $product->weight;
			$workmanship = $product->workmanship;
			$material = Material::where('id', $product->material_id)->first();

			$stone = array(
				'isSet' => false,
				'display_name' => '',
				'accumulated_weight' => 0
			);

			if(isset($product->stones) && is_object($product->stones)){
				foreach($product->stones as $k=>$productStone){
					// Stone Name to be displayed on the Label
					if($stone['display_name']==''){
						if(isset($productStone->stone_id) && $productStone->stone_id>0){
							$stone = Stone::where('id', $productStone->stone_id)->first();
							if(isset($stone->nomenclature_id)){
								$stoneName = Nomenclature::where('id', $stone->nomenclature_id)->first();
								if(isset($stoneName->name)){
									$stone['display_name'] = $stoneName->name;
									$stone['isSet'] = true;
								}
							}
						}
					}

					// Stone weight to accumulate
					if(isset($productStone->weight) && $productStone->weight>0){
						$stone['accumulated_weight'] += $productStone->weight;
					}
				}
			}

			$mpdf = new \Mpdf\Mpdf([
				'mode' => 'utf-8',
				'format' => [96, 11.4],
				'margin_top' => 1,
				'margin_bottom' => 0,
				'margin_left' => 3,
				'margin_right' => 0,
				'mirrorMargins' => true
			]);

			$html = view('pdf.label', compact('barcode', 'weight', 'workmanship', 'product', 'material', 'stone'))->render();

			$mpdf->WriteHTML($html);

			// For development purposes
			// $mpdf->Output();
			// exit;

			$mpdf->Output(str_replace(' ', '_', $product->name).'_label.pdf',\Mpdf\Output\Destination::DOWNLOAD);
		}

		abort(404, 'Product not found.');
	}
}