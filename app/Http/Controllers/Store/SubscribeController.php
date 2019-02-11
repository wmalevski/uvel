<?php

namespace App\Http\Controllers\Store;
use Newsletter;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class SubscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'email' => 'required|string|email|max:255',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        Newsletter::subscribe($request->email);
        return Redirect::back()->with('success.subscribe', 'Успешно се абонирахте!');
    }

    public function unsubscribe($email)
    {
        Newsletter::unsubscribe($email);
        return Redirect::back()->with('success.subscribe', 'Успешно си махнахте абонирането!');
    }


}
