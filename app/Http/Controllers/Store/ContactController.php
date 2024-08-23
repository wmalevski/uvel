<?php

namespace App\Http\Controllers\Store;
use Newsletter;
use Response;
use App\MaterialType;
use App\ProductOtherType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Mail;

class ContactController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return \View::make('store.pages.contact');
    }

    public function store(Request $request){
        $validator = Validator::make( $request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        //Send email to support mail
        $requestEmail   = $request->email;
        $requestName    = $request->name;

        Mail::send('email',
            array(
                'name'          => $requestName,
                'email'         => $requestEmail,
                'user_message'  => $request->message
            ), function($message) use ($requestName, $requestEmail) {
                $message->from($requestEmail);
                $message->to("uvelgold@gmail.com")->subject("Контактна форма: $requestName");
        });

        return Redirect::back()->with('success.contact', 'Съобщението ви беше изпратено успешно');
    }
}
