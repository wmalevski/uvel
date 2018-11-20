<?php

namespace App\Http\Controllers;

use App\CustomOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Gallery;
use Response;
use Mail;

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
        return \View::make('admin/orders/custom/edit',array('order'=>$order));
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

        $path = public_path('uploads/orders/');
        
        File::makeDirectory($path, 0775, true, true);
        Storage::disk('public')->makeDirectory('orders', 0775, true);

        $file_data = $request->input('images'); 
        if($file_data){
            foreach($file_data as $img){
                $memi = substr($img, 5, strpos($img, ';')-5);
                
                $extension = explode('/',$memi);
                if($extension[1] == "svg+xml"){
                    $ext = 'png';
                }else{
                    $ext = $extension[1];
                }
                

                $file_name = 'productimage_'.uniqid().time().'.'.$ext;

                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                file_put_contents(public_path('uploads/orders/').$file_name, $data);

                Storage::disk('public')->put('orders/'.$file_name, file_get_contents(public_path('uploads/orders/').$file_name));

                $photo = new Gallery();
                $photo->photo = $file_name;
                $photo->custom_order_id = $product->id;
                $photo->table = 'orders';
                $photo->save();
            }
        }
        
        $order->save();

        return Response::json(array('ID' => $order->id, 'table' => View::make('admin/orders/custom/table',array('order'=>$order))->render()));
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
