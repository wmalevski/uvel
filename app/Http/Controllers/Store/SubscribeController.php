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
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        Newsletter::subscribe($request->email);
        //echo 'You have subscribed successfully!';
        return Response::json(array('success' => 'Успешно се абонирахте!'));
    }

    public function unsubscribe($email)
    {
        Newsletter::unsubscribe($email);
        echo 'You have unsubscribed successfully!';
    }


}
