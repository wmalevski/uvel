<?php

namespace App\Http\Controllers;

use App\ModelOrder;
use Illuminate\Http\Request;

class ModelOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = ModelOrder::all();
        
        return view('admin.orders.model.index', compact('orders'));
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

    /**
     * Display the specified resource.
     *
     * @param  \App\ModelOrder  $modelOrder
     * @return \Illuminate\Http\Response
     */
    public function show(ModelOrder $modelOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ModelOrder  $modelOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(ModelOrder $order)
    {
        return \View::make('admin/orders/model/edit',array('order'=>$order));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ModelOrder  $modelOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModelOrder $order)
    {
        $validator = Validator::make( $request->all(), [
            'model_id' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $order->model_id = $request->model_id;
        
        $order->save();

        return Response::json(array('ID' => $order->id, 'table' => View::make('admin/orders/model/table',array('order'=>$order))->render()));
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
