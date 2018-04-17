<?php

namespace App\Http\Controllers;

use App\User;
use App\Stores;
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
        $stores = Stores::all();
        
        return \View::make('admin/users/index', array('users' => $users, 'stores' => $stores));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(User $users, $user)
    {
        $user = User::find($user);
        $stores = Stores::all();
        
        return \View::make('admin/users/edit', array('user' => $user, 'stores' => $stores));
    }

    public function update(Request $request, User $users, $user)
    {
        $user = User::find($user);
        
        $user->name = $request->name;
        $user->store = $request->store;
        $user->retract($user->roles->first()['name']);
        $user->assign($request->role);

        // $user->detachRoles($user->roles);
        // $user->roles()->attach([$request->role]);
        
        $user->save();

        // foreach($request->permissions as $permision){
        //     print_r($permision);
        // }

        // foreach($request->permissions as $role){
        //     //$abillity = Bouncer::ability($role)->first();
        //     Bouncer::allow($user)->to($role);

        //     print_r($abillity);
        // }
    
        //return Response::json(array('table' => View::make('admin/users/table',array('user'=>$user))->render()));
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
         ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        //$user = User::create($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'store' => $request->store
        ]);

        //$user->attachRole($request->role);
        //$user->roles()->attach([$request->role]);

        $user->assign($request->role);
        
        return Response::json(array('success' => View::make('admin/users/table',array('user'=>$user))->render()));
    }
}