<?php

namespace App\Http\Controllers;

use App\CustomOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Gallery;
use Response;
use Mail;
use File;
use Storage;

class CustomOrderController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $orders = CustomOrder::orderBy('id','DESC')->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);
        $attachment = $request->get('blob');

        return view('admin.orders.custom.index', compact('orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomOrder  $customOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomOrder $order){
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
    public function update(Request $request, CustomOrder $order){
        $validator = Validator::make( $request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255',
            'content' => 'required|string',
            'phone' => 'required',
            'city' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $order->name = $request->name;
        $order->email = $request->email;
        $order->content = $request->content;
        $order->phone = $request->phone;
        $order->city = $request->city;

        // If an image is uploaded
        $file_data = $request->input('images');
        if (isset($request->images)) {

            $path = public_path('uploads/orders/');
            File::makeDirectory($path, 0775, true, true);
            Storage::disk('public')->makeDirectory('orders', 0775, true);

            foreach($file_data as $img){
                $ext       = pathinfo($img, PATHINFO_EXTENSION);
                $file_name = 'orderimage_'.uniqid().time().'.'.$ext;
                $data      = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));

                file_put_contents(public_path('uploads/orders/').$file_name, $data);

                Storage::disk('public')->put('orders/'.$file_name, file_get_contents(public_path('uploads/orders/').$file_name));
                $photo = $order->photos->first();
                if ( !$photo ) {
                    $photo = new Gallery();
                }

                $photo->photo = $file_name;
                $photo->custom_order_id = $order->id;
                $photo->table = 'orders';

                $photo->save();
            }
        }

        if(isset($request->deadline)){
            $temp = explode('/', $request->deadline);
            $order->deadline = $temp[2].'-'.$temp[1].'-'.$temp[0];
        }

        $order->offer = $request->offer;
        $order->ready_product = $request->ready_product;

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
        $orders = $orders->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $response = '';
        foreach($orders as $order){
            $response .= \View::make('admin/orders/custom/table', array('order' => $order, 'listType' => $request->listType));
        }

        $orders->setPath('');
        $response .= $orders->appends(request()->except('page'))->links();

        return $response;
    }

    public function generatePDF($order){
        $custom = CustomOrder::where('id',$order)->first();
        if(!$order || $custom->count() < 1){
            abort(404, 'Възникна проблем при намирането на поръчката!');
        }

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => '12',
            'margin-left' => 20,
            'margin-right' => 20,
            'margin-top' => 20,
            'margin-bottom' => 20,
            'margin-header' => 80,
            'margin-footer' => 0,
            // 'showImageErrors' => true, // Dev purposes
            'title' => "Поръчка №".$custom->id
        ]);

        $html = '<style>@page{margin: 30px;}</style>'.view('pdf.custom_order', compact('custom'))->render();

        $mpdf->WriteHTML($html);

        // For development purposes
        // $mpdf->Output();
        // exit;

        $mpdf->Output(str_replace(' ', '_', $custom->id) . '_custom_order.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }
}
