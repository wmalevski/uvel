<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Material;
use App\ProductOther;

class GenerateLabelController extends Controller
{
    public function generate($barcode) {

        $product = Product::where('barcode', $barcode)->first();

        if($product) {
            $weight = $product->weight;
            $workmanship = $product->workmanship;
            $material = Material::where('id', $product->material_id)->first();
            $stone = calculate_product_weight($product);

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

            $mpdf->Output(str_replace(' ', '_', $product->name).'_label.pdf',\Mpdf\Output\Destination::DOWNLOAD);
        }

        abort(404, 'Product not found.');
    }
}
