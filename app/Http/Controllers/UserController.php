<?php

namespace App\Http\Controllers;

use App\User;
use App\Stores;
use Illuminate\Http\Request;

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
        
        return \View::make('admin/users/index', array('users' => $users));
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
        
        // $store->name = $request->name;
        // $store->location = $request->location;
        // $store->phone = $request->phone;
        
        // $store->save();
        
        //return Response::json( View::make('admin/stores/edit', array('store' => $store))->render());
    }
}
