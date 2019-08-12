<?php

use App\Stone;
use App\Nomenclature;
use App\ProductStone;
use Illuminate\Support\Str;

if (!function_exists('calculate_product_weight')) {
    /**
     *
     * Calculate product weight.
     *
     * @return string
     */
    function calculate_product_weight($product)
    {
        if ($product->stones->first() && ($stone = Stone::where('id', $product->stones->first()->stone_id)->first())) {
            $stoneAbb = [];
            foreach ($product->stones as $productStone) {
                $stoneId = $productStone->stone_id;
                $stoneName = Nomenclature::where('id', $stoneId)->first()->name;
                $stoneWeight = $product->gross_weight - $product->weight;
                if ($product->weight_without_stones == 'yes' && Str::lower($product->material->name) == "сребро") {
                    $weight = round($product->gross_weight, 3);
                } else {
                    $weight = round($product->weight, 3);
                }
                if (Stone::where('id', $stoneId)->first()->type != 1) {
                    $stoneCarat = Stone::where('id', $stoneId)->first()->carat;
                    $stoneAbb[] = $stoneName . ' ' . $stoneCarat . 'кт.';
                } else {
                    $stoneAbb[] = $stoneName . ' ' . $stoneWeight . 'гр.';
                }
            }
        } else {
            $weight = round($product->weight, 3);
        }

        $weightStoneData['weight'] = $weight;
        if (isset($stoneAbb)) {
            $weightStoneData['stone'] = $stoneAbb;
        }

        return $weightStoneData;
    }
}