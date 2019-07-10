<?php

use App\Stone;
use App\Nomenclature;
use App\ProductStone;
use Illuminate\Support\Str;

if( ! function_exists('calculate_product_weight') ) {
    /**
     *
     * Calculate product weight.
     *
     * @return string
     */
    function calculate_product_weight($product)
    {
        $checkWeight = false;
        if ($product->weight_without_stones) {
            if (Str::lower($product->material->name) == "сребро") {
                $weight = round($product->gross_weight, 3);
            } elseif (Str::lower($product->material->name) == "злато") {
                if (($stone = Stone::where('id', $product->stones->first()->stone_id)->first()) && $stone->type != 1) {
                    $stoneId = $product->stones->first()->stone_id;
                    $stoneCarat = Stone::where('id', $stoneId)->first()->carat;
                    $stoneName = Nomenclature::where('id', $stoneId)->first()->name;
                    $stoneWeight = $product->gross_weight - $product->weight;
                    $weight = round($product->weight, 3) . '+' . $stoneWeight;
                    $stone = $stoneName . ' ' . $stoneCarat;
                } else {
                    $checkWeight = true;
                }
            } else {
                $checkWeight = true;
            }
        } else {
            $checkWeight = true;
        }
        if ($checkWeight) {
            $weightStoneData['weight'] = round($product->weight, 3);
        } else {
            $weightStoneData['weight'] = $weight;
            if (isset($stone)) {
                $weightStoneData['stone'] = $stone;
            }
        }

        return $weightStoneData;
    }
}