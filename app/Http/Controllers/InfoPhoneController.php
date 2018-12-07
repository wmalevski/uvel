<?php

namespace App\Http\Controllers;

use App\InfoPhone;
use Illuminate\Http\Request;

class InfoPhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phones = InfoPhone::all();
        
        return view('admin.info_phones.index', compact('phones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
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
            'phone' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $phone = InfoPhone::create($request->all());

        return Response::json(array('success' => View::make('admin/info_phones/table',array('phone'=>$phone))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InfoPhones  $infoPhones
     * @return \Illuminate\Http\Response
     */
    public function show(InfoPhone $infoPhones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InfoPhones  $infoPhones
     * @return \Illuminate\Http\Response
     */
    public function edit(InfoPhone $phone)
    {
        return \View::make('admin/info_phones/edit',array('phone'=>$phone));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InfoPhones  $infoPhones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfoPhones $infoPhones)
    {
        $validator = Validator::make( $request->all(), [
            'title' => 'required',
            'phone' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }
        
        $phone->title = $request->title;
        $phone->phone = $request->phone;
        
        $phone->save();

        return Response::json(array('ID' => $phone->id, 'table' => View::make('admin/info_phones/table',array('phone'=>$phone))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InfoPhones  $infoPhones
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfoPhone $phone)
    {
        if($phone){
            $phone->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
