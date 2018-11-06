<?php

namespace App\Http\Controllers;

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

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $stores = Store::all();
        
        return \View::make('admin/users/index', array('users' => $users, 'stores' => $stores));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $stores = Store::all();
        
        return \View::make('admin/users/edit', array('user' => $user, 'stores' => $stores));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make( $request->all(), [
            'name' => 'required|string|max:255',
            'role' => 'required',
            'store_id' => 'required'
         ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }
        
        $user->name = $request->name;
        $user->store_id = $request->store_id;

        $user->save();

        Bouncer::sync($user)->roles([$request->role]);
    
        return Response::json(array('ID' => $user->id, 'table' => View::make('admin/users/table',array('user'=>$user))->render()));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required',
            'store_id' => 'required'
         ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'store_id' => $request->store_id
        ]);

        $user->assign($request->role);
        
        return Response::json(array('success' => View::make('admin/users/table',array('user'=>$user))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $stores
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user){
            foreach($user->discountCodes as $discountCode) {
                if($discountCode->active == "yes") {
                   $discountCode->active = "no";
                   $discountCode->save();
                }
            }
            
            $user->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}