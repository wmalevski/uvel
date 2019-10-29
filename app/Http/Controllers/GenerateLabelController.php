<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductOther;
use PDF;

class GenerateLabelController extends Controller
{
    public function generate($barcode) {
        $product = Product::where('barcode', $barcode)->first();

        if($product) {
            $pdf = PDF::loadView('pdf.label', $product);

	        return $pdf->download($product->name.'_label.pdf');
        }

        abort(404, 'Product not found.');
    }
}
