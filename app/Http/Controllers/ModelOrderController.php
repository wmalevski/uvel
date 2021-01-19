<?php

namespace App\Http\Controllers;

use App\Model;
use App\ModelOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Response;
use App\Http\Controllers\Store\ModelController;
use Illuminate\Support\Facades\Input;

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
        $models = Model::all();
        return \View::make('admin/orders/model/edit',array('order'=>$order, 'models' => $models));
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
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $order->model_id = $request->model_id;
        $order->additional_description = $request->additional_description;

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

    public function filter(Request $request){
        $query = ModelOrder::select('*');

        $orders_new = new ModelOrder();
        $orders = $orders_new->filterOrders($request, $query);
        $orders = $orders->paginate(\App\Setting::where('key','per_page')->get()[0]->value);

        $response = '';
        foreach($orders as $order){
            $response .= \View::make('admin/orders/model/table', array('order' => $order, 'listType' => $request->listType));
        }

        $orders->setPath('');
        $response .= $orders->appends(Input::except('page'))->links();

        return $response;
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
