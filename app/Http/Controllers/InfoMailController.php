<?php

namespace App\Http\Controllers;

use App\InfoMail;
use Illuminate\Http\Request;

class InfoMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = InfoMail::all();
        
        return view('admin.info_emails.index', compact('emails'));
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
            'title' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $email = InfoMail::create($request->all());

        return Response::json(array('success' => View::make('admin/info_emails/table',array('email'=>$email))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InfoMails  $infoMails
     * @return \Illuminate\Http\Response
     */
    public function show(InfoMail $infoMails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InfoMails  $infoMails
     * @return \Illuminate\Http\Response
     */
    public function edit(InfoMail $email)
    {
        return \View::make('admin/info_emails/edit',array('email'=>$email));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InfoMails  $infoMails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfoMail $email)
    {
        $validator = Validator::make( $request->all(), [
            'title' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }
        
        $email->title = $request->title;
        $email->email = $request->email;
        
        $email->save();

        return Response::json(array('ID' => $email->id, 'table' => View::make('admin/info_emails/table',array('email'=>$email))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InfoMails  $infoMails
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfoMail $email)
    {
        if($email){
            $email->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
