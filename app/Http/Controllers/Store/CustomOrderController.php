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
use App\CMS;
use App\Setting;

class CustomOrderController extends BaseController{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return \View::make('store.pages.orders.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
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

        $email2sms = new Setting();
        $email2sms = $email2sms->get('email2sms_on_order');

        // Send Email-to-SMS to the admin, only if the environment is not LOCAL or DEVELOPMENT
           Mail::send('store.emails.sms',array(
               'content' => "Porychka po model! ID ".$customOrder->id),
               function($message) {
                   $message
                       ->from(config('mail.username'),config('app.name'))
                       ->to(config('mail.host'))
                       ->subject('Po model');
               }
           );

        if(
            (strtolower($_ENV['APP_ENV'])!=='local'&&strtolower($_ENV['APP_ENV'])!=='development')
            &&
            filter_var($email2sms, FILTER_VALIDATE_EMAIL)
        ){
//            Mail::send('store.emails.sms',array(
//                'content' => "Porychka po model! ID ".$customOrder->id),
//                function($message) use ($email2sms){
//                    $message
//                        ->from($_ENV['MAIL_USERNAME'],$_ENV['APP_NAME'])
//                        ->to($email2sms)
//                        ->subject('Po model');
//                }
//            );
        }


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
            ),
            function($message) use ($requestEmail){
                $message
                    ->replyTo($requestEmail)
                    ->from(config('mail.username'), config('app.name'))
                    ->to("uvelgold@gmail.com")
                    ->subject('Uvel Поръчка');
            }
        );

        return Response::json(array(
            'success' => 'Поръчката Ви беше изпратено успешно',
            'hideForm' => 'true',
            'showSuccess' => CMS::get('customOrderReceived')
        ));
    }

}