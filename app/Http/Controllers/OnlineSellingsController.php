<?php

namespace App\Http\Controllers;

use App\UserPayment;
use App\Model;
use App\ModelOrder;
use App\Store;
use App\UserPaymentProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Response;

class OnlineSellingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellings = UserPayment::all();
        
        return view('admin.selling.online.index', compact('sellings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $model)
    {
        
    }

    /**UserPayment
     * Display the specified resource.
     *
     * @param  \App\ModelOrder  $modelOrder
     * @return \Illuminate\Http\Response
     */
    public function show(UserPayment $modelOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ModelOrder  $modelOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPayment $selling)
    {
        $stores = Store::all();
        $products = UserPaymentProduct::where('payment_id', $selling->id)->get();
        return \View::make('admin/selling/online/edit', array('selling' => $selling, 'stores' => $stores, 'products' => $products));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserPayment  $modelOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPayment $selling)
    {
        $selling->status = 'done';
        $selling->save();

        return Response::json(array('ID' => $selling->id, 'table' => View::make('admin/selling/online/table',array('selling'=>$selling))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ModelOrder  $modelOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelOrder $modelOrder)
    {
        //
    }
}
