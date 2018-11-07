<?php

namespace App\Http\Controllers\Store;
use Newsletter;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Mail;

class ContactController extends Controller
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
        $this->contactUSPost($request);
        return Redirect::back()->with('success', 'Съобщението ви беше изпратено успешно');
    }

    /** * Show the application dashboard. * * @return \Illuminate\Http\Response */
    public function contactUSPost(Request $request) 
    {
        $this->validate($request, [ 'name' => 'required', 'email' => 'required|email', 'message' => 'required' ]);; 
    
        Mail::send('email',
        array(
            'name' => $request->name,
            'email' => $request->email,
            'user_message' => $request->message
        ), function($message)
    {
        $message->from('galabin@rubberduck.xyz');
        $message->to('galabin@rubberduck.xyz', 'Admin')->subject('Uvel Contact');
    });
    }

}
