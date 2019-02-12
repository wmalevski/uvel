<?php

namespace App\Http\Controllers;
use Newsletter;
use App\ModelStone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Response;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribers = Newsletter::getMembers('subscribers');
        return view('admin.mailchimp.index', compact('subscribers'));
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
            'email' => 'required|string|email|max:255',
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        if(Newsletter::isSubscribed($request->email)){
            return Response::json(['errors' => ['subscribed' => trans('admin/subscribers.already_subscribed')]], 401);
        }

        Newsletter::subscribe($request->email);
        $subscriber = Newsletter::getMember($request->email);

        return Response::json(array('success' => View::make('admin/mailchimp/table',array('subscriber'=>$subscriber))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Newsletter  $model_stones
     * @return \Illuminate\Http\Response
     */
    public function show(Newsletter $Newsletter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Newsletter  $model_stones
     * @return \Illuminate\Http\Response
     */
    public function edit(Newsletter $Newsletter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Newsletter  $model_stones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Newsletter $Newsletter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Newsletter  $model_stones
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newsletter $Newsletter, $subscriber)
    {
        Newsletter::unsubscribe($subscriber);
    }
}
