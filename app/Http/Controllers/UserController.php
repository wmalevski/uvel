<?php

namespace App\Http\Controllers;

use App\User;
use App\Stores;
use Illuminate\Http\Request;
use Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

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
        
        $user->name = $request->name;
        $user->store = $request->store;
        
        $user->save();
        
        return Response::json( View::make('admin/users/table', array('user' => $user))->render());
    }
}
