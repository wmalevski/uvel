<?php

namespace App\Http\Controllers\Store;

use App\CustomOrder;
use App\Gallery;
use App\InfoMails;
use App\InfoPhones;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;
use File;
use Storage;
use Mail;
use Auth;

class CustomOrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \View::make('store.pages.orders.index');
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
        $validator = Validator::make( $request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255',
            'content' => 'required|string',
            'phone' => 'required',
            'city' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $customOrder = CustomOrder::create($request->all());

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


                $file_name = 'orderimage_'.uniqid().time().'.'.$ext;

                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                file_put_contents(public_path('uploads/orders/').$file_name, $data);

                Storage::disk('public')->put('orders/'.$file_name, file_get_contents(public_path('uploads/orders/').$file_name));

                $photo = new Gallery();
                $photo->photo = $file_name;
                $photo->custom_order_id = $customOrder->id;
                $photo->table = 'orders';
                $photo->save();
            }
        }

        //send sms to the admin
        Mail::send('sms',
            array(
                'content' => "Porychka po model! ID $customOrder->id"
            ), function($message) {
                $message->from("info@uvel.bg");
                $message->to("359888770160@sms.telenor.bg")->subject('Po model');
            });

        //send email to uvelgold@gmail.com from the customer
        $requestEmail = $request->email;

        Mail::send('order',
        array(
            'ID' => $customOrder->id,
            'name' => $request->name,
            'email' => $requestEmail,
            'city' => $request->city,
            'phone' => $request->phone,
            'content' => $request->content
        ), function($message) use ($requestEmail) {
            $message->from($requestEmail);
            $message->to("uvelgold@gmail.com")->subject('Uvel Поръчка');
        });

        return Response::json(array('success' => 'Поръчката ви беше изпратено успешно'));
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
    public function edit(CustomOrder $customOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomOrder  $customOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomOrder $customOrder)
    {
        //
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
