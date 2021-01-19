<?php

namespace App\Http\Controllers;

use App\CustomOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Gallery;
use Response;
use Mail;
use File;
use Storage;

class CustomOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = CustomOrder::all();

        return view('admin.orders.custom.index', compact('orders'));
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
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomOrder  $customOrder
     * @return \Illuminate\Http\Response
     */
    public function show(CustomOrder $customOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomOrder  $customOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomOrder $order)
    {
        $photos = $order->photos()->get();
        $pass_photos = array();

        foreach($photos as $photo){
            $url =  Storage::get('public/orders/'.$photo->photo);
            $ext_url = Storage::url('public/orders/'.$photo->photo);

            $info = pathinfo($ext_url);

            $image_name =  basename($ext_url,'.'.$info['extension']);

            $base64 = base64_encode($url);

            if($info['extension'] == "svg"){
                $ext = "png";
            }else{
                $ext = $info['extension'];
            }

            $pass_photos[] = [
                'id' => $photo->id,
                'photo' => 'data:image/'.$ext.';base64,'.$base64
            ];
        }

        return \View::make('admin/orders/custom/edit',array('order'=>$order, 'basephotos' => $pass_photos));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomOrder  $customOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomOrder $order)
    {
        $validator = Validator::make( $request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255',
            'content' => 'required|string',
            'phone' => 'required',
            'city' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $order->name = $request->name;
        $order->email = $request->email;
        $order->content = $request->content;
        $order->phone = $request->phone;
        $order->city = $request->city;

        if($request->status_accept == 'true'){
            $order->status = 'accepted';
        } else if($request->status_ready == 'true'){
            $order->status = 'ready';
        } else if($request->status_delivered == 'true'){
            $order->status = 'delivered';
        }

        $order->save();

        return Response::json(array('ID' => $order->id, 'table' => View::make('admin/orders/custom/table',array('order'=>$order))->render()));
    }

    public function filter(Request $request){
        $query = CustomOrder::select('*');

        $orders_new = new CustomOrder();
        $orders = $orders_new->filterOrders($request, $query);
        $orders = $orders->paginate(\App\Setting::where('key','per_page')->get()[0]->value);

        $response = '';
        foreach($orders as $order){
            $response .= \View::make('admin/orders/custom/table', array('order' => $order, 'listType' => $request->listType));
        }

        $orders->setPath('');
        $response .= $orders->appends(Input::except('page'))->links();

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomOrder  $customOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomOrder $customOrder)
    {
        //
    }
}
