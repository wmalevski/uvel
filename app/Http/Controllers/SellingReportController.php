<?php


namespace App\Http\Controllers;

use App\Payment;
use App\PaymentDiscount;
use App\Product;
use App\Selling;
use App\Store;

class SellingReportController  extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::where('id', '!=', 1)->orderBy('id', 'DESC')->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);
        $payments = Payment::selectRaw('sum(price) as price')->selectRaw('count(*) as total, store_id')->selectRaw('avg(price) as avg_price')->groupBy('store_id')->get();
        $payments_id = Payment::groupBy('store_id')->selectRaw('id')->get();

        return view('admin.selling_reports.index', compact(['stores', 'payments',  'payments_id']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        $payments = Payment::join('sellings', 'sellings.payment_id', '=', 'payments.id')->where('payments.store_id', $store->id)->selectRaw('sellings.product_id')->selectRaw('payments.id')->selectRaw('payments.method')->selectRaw('payments.user_id')->get();
        $products = Product::all();

        return view('admin.selling_reports.edit', compact(['store', 'payments', 'products']));
    }

}