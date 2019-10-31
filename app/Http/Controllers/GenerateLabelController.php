<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductOther;

class GenerateLabelController extends Controller
{
    public function generate($barcode) {

        $product = Product::where('barcode', $barcode)->first();

        if($product) {
            $weight = $product->weight;
            $workmanship = $product->workmanship;

            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => [100, 70]
            ]);

            $html = view('pdf.label', compact('barcode', 'weight', 'workmanship'))->render();

            $mpdf->WriteHTML($html);

            $mpdf->Output(str_replace(' ', '_', $product->name).'_label.pdf',\Mpdf\Output\Destination::DOWNLOAD);
        }

        abort(404, 'Product not found.');
    }
}
