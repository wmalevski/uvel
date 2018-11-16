<?php

namespace App\Http\Controllers;

use App\UserPayment;
use App\Model;
use App\ModelOrder;
use App\Store;
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
        return \View::make('admin/selling/online/edit', array('selling' => $selling, 'stores' => $stores));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserPayment  $modelOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPayment $order)
    {
        $validator = Validator::make( $request->all(), [
            'model_id' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $order->model_id = $request->model_id;

        if($request->status_accept == 'true'){
            $order->status = 'accepted';
        } else if($request->status_ready == 'true'){
            $order->status = 'ready';
        } else if($request->status_delivered == 'true'){
            $order->status = 'delivered';
        }
        
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
