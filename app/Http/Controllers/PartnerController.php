<?php

namespace App\Http\Controllers;

use App\Partner;
use App\User;
use App\Store;
use App\Permission;
use Response;
use Bouncer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PartnerController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $partners = Partner::all();
        return \View::make('admin/partners/index', array('partners' => $partners));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner){
        return \View::make('admin/partners/edit', array('partner' => $partner));
    }

    public function update(Request $request, Partner $partner){
        $validator = Validator::make( $request->all(), [
            'money' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $partner->money = $request->money;

        $partner->save();

        return Response::json(array('ID' => $partner->id, 'table' => View::make('admin/partners/table', array('partner' => $partner))->render()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        // $validator = Validator::make( $request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6|confirmed',
        //     'role' => 'required',
        //     'store_id' => 'required'
        //  ]);

        // if ($validator->fails()) {
        //     return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        // }

        // //$user = User::create($request->all());

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password),
        //     'store_id' => $request->store_id
        // ]);

        // //$user->attachRole($request->role);
        // //$user->roles()->attach([$request->role]);

        // $user->assign($request->role);

        // return Response::json(array('success' => View::make('admin/users/table',array('user'=>$user))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $stores
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user){
        // if($user){
        //     foreach($user->discountCodes as $discountCode) {
        //         if($discountCode->active == "yes") {
        //            $discountCode->active = "no";
        //            $discountCode->save();
        //         }
        //     }
        //     $user->delete();
        //     return Response::json(array('success' => 'Успешно изтрито!'));
        // }
    }
}