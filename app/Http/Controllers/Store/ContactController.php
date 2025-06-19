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
            'g-recaptcha-response' => 'required|recaptcha'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $requestEmail   = $request->email;
        $requestName    = $request->name;

       Mail::send('email',
    [
        'name'         => $request->name,
        'email'        => $request->email,
        'user_message' => $request->message
    ],
    function ($message) use ($request) {
        $message
            ->from(config('mail.from.address'), config('mail.from.name')) // напр. auto@uvel.bg
            ->replyTo($request->email, $request->name)
            ->to('uvelgold@gmail.com')
            ->subject("Контактна форма: {$request->name}");
    }
);

        return Redirect::back()->with('success.contact', 'Съобщението ви беше изпратено успешно');
    }
}
