<?php

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
        if ($product->weight_without_stones) {
            if (Str::lower($product->material->name) == "сребро") {
                $weight = $product->gross_weight;
            } elseif (Str::lower($product->material->name) == "злато") {
                $weight = $product->weight . "+" . ($product->gross_weight - $product->weight);
            } else {
                $weight = $product->weight;
            }
        } else {
            $weight = $product->weight;
        }

        return $weight;
    }
}