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
use App\Selling;
use App\Store;

class ModelOrderController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $orders = Selling::where(array(array('model_id','!=',NULL)))->orderBy('id','DESC')->get();
        return view('admin.orders.model.index', compact('orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ModelOrder  $modelOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(Selling $order){
        $models = Model::all();
        $stores = Store::all();
        $store_info = ($order->user_payment->store_id ? Store::where('id',$order->user_payment->store_id)->first() : null);
        return \View::make('admin/orders/model/edit', compact('order', 'models', 'stores', 'store_info'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ModelOrder  $modelOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Selling $order){
        $validator = Validator::make( $request->all(), array('model_id'=>'required'));

        if($validator->fails()){
            return Response::json(array('errors'=>$validator->getMessageBag()->toArray()),401);
        }

        if(isset($request->deadline)){
            $temp = explode('/', $request->deadline);
            $order->deadline = $temp[2].'-'.$temp[1].'-'.$temp[0];
        }

        $order->user_payment->phone = $request->phone;
        $order->user_payment->city = $request->city;

        if(isset($request->store_id)){
            $order->user_payment->store_id = $request->store_id;
        }
        else{
            $order->user_payment->shipping_address = $request->shipping_address;
        }

        $order->model_id = $request->model_id;
        $order->model_size = $request->model_size;
        $order->user_payment->information = $request->information;

        if($request->status_accept == 'true'){          $order->model_status = 'accepted';}
        elseif($request->status_ready == 'true'){       $order->model_status = 'ready';}
        elseif($request->status_delivered == 'true'){   $order->model_status = 'delivered';}

        $order->user_payment->save();
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
