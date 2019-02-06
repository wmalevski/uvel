<?php

namespace App\Http\Controllers;

use App\UserSubstitution;
use Illuminate\Http\Request;
use App\Store;
use App\User;
use Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class UsersubstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeSubstitutions = UserSubstitution::where(
            'date_to', '>=', date("Y-m-d")
        )->get();

        $inactiveSubstitutions = UserSubstitution::where(
            'date_to', '<', date("Y-m-d")
        )->get();

        $stores = Store::take(env('SELECT_PRELOADED'))->get();
        $users = User::whereIsNot('customer')->take(env('SELECT_PRELOADED'))->get();
        
        return \View::make('admin/substitutions/index', array('activeSubstitutions' => $activeSubstitutions, 'inactiveSubstitutions' => $inactiveSubstitutions, 'stores' => $stores, 'users' => $users));
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
        $status = 0;
        
        $substitution = UserSubstitution::where([
            ['user_id', '=', $request->user],
            ['date_to', '>=', date("Y-m-d")]
        ])->first();

        if($substitution){
            return Response::json(['errors' => ['already_sub' => ['Този потребител вмомента замества в друг магазин']]], 401);

        } else{
            $validator = Validator::make( $request->all(), [
                'user_id' => 'required',
                'store_id' => 'required',
                'dateFrom' => 'required',
                'dateTo' => 'required',
             ]);
            
            if ($validator->fails()) {
                return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
            }
            
            $user = User::find($request->user_id);

            if($user->store_id != $request->store_id){
                $status = 1;
                $place = 'active';
                $substitution = new UserSubstitution();
                $substitution->user_id = $request->user_id;
                $substitution->store_id = $request->store_id;
                $substitution->date_from = date('Y-m-d', strtotime($request->dateFrom));
                $substitution->date_to = date('Y-m-d', strtotime($request->dateTo));
        
                $substitution->save();

                if($substitution->date_to < date("Y-m-d")){
                    $place = 'inactive';
                }

                return Response::json(array('success' => View::make('admin/substitutions/table',array('substitution'=>$substitution))->render(), 'place' => $place));
            }else{
                return Response::json(['errors' => ['same_store' => ['Не може да изпратите потребителя в същият магазин']]], 401);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserSubstitution  $usersubstitutions
     * @return \Illuminate\Http\Response
     */
    public function show(UserSubstitution $usersubstitution, $user)
    {
        // $stores = Store::all();

        // $status = 0;

        // $substitution = UserSubstitution::where([
        //     ['user_id', '=', $user],
        //     ['date_to', '>=', date("dd-mm-yyyy")]
        // ])->first();

        // if($substitution){
        //     $status = 1;
        // }

        // if($status == 0){
        //     return \View::make('admin/users/substitutions', array('user' => $user, 'stores' => $stores));
        // } else if($status == 1){
        //     return \View::make('admin/users/alreadysub', array('user' => $user, 'store' => $substitution->store_id, 'dateFrom' => $substitution->date_from, 'dateTo' => $substitution->date_to));
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Usersubstitutions  $usersubstitutions
     * @return \Illuminate\Http\Response
     */
    public function edit(UserSubstitution $userSubstitution)
    {
        $stores = Store::withTrashed()->get();
        $users = User::withTrashed()->get();
        $place = 'active';

        if($userSubstitution->date_to < date("Y-m-d")){
            $place = 'inactive';
        }
        
        return \View::make('admin/substitutions/edit', array('users' => $users, 'stores' => $stores, 'substitution' => $userSubstitution, 'place' => $place));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserSubstitution  $usersubstitutions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserSubstitution $userSubstitution)
    {
        if($userSubstitution){
            $validator = Validator::make( $request->all(), [
                'user_id' => 'required',
                'store_id' => 'required',
                'dateFrom' => 'required',
                'dateTo' => 'required',
             ]);
            
            if ($validator->fails()) {
                return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
            }

            $place = 'active';
            $userSubstitution->user_id = $request->user_id;
            $userSubstitution->store_id = $request->store_id;
            $userSubstitution->date_from = date('Y-m-d', strtotime($request->dateFrom));
            $userSubstitution->date_to = date('Y-m-d', strtotime($request->dateTo));

            if($userSubstitution->date_to < date("Y-m-d")){
                $place = 'inactive';
            }

    
            $userSubstitution->save();
    
            return Response::json(array('ID' => $userSubstitution->id, 'table' => View::make('admin/substitutions/table',array('substitution'=>$userSubstitution))->render(), 'place' => $place));
        }
    }

    public function setStore(){
        $substitution = UserSubstitution::substitution();

        if($substitution){
            Auth::user()->store = $substitution->store_id;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserSubstitution  $usersubstitutions
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSubstitution $userSubstitution)
    { 
        if($userSubstitution){
            $userSubstitution->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
