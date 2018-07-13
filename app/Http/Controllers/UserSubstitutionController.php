<?php

namespace App\Http\Controllers;

use App\UserSubstitution;
use Illuminate\Http\Request;
use App\Stores;
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

        $stores = Stores::all();
        $users = User::whereIsNot('customer')->get();
        
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

        // foreach($substitution as $sub){
        //     //print_r(date("d-m-Y"));  print_r($sub->date_to); die;
        //     if($sub->date_to >= date("d-m-Y")){
        //         $status = 1;
        //     }
        // }

        if($substitution){
            return Response::json(['errors' => ['already_sub' => ['Този потребител вмомента замества в друг магазин']]], 401);

        } else{
            $validator = Validator::make( $request->all(), [
                'user' => 'required',
                'store' => 'required',
                'dateFrom' => 'required',
                'dateTo' => 'required',
             ]);
            
            if ($validator->fails()) {
                return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
            }
            
            $user = User::find($request->user);

            if($user->store != $request->store){
                $status = 1;
                $place = 'active';
                $substitution = new UserSubstitution();
                $substitution->user_id = $request->user;
                $substitution->store_id = $request->store;
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
        // $stores = Stores::all();

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
        $substitution = UserSubstitution::find($userSubstitution);
        $stores = Stores::withTrashed()->get();
        $users = User::withTrashed()->get();
        $place = 'active';

        if($substitution->date_to < date("Y-m-d")){
            $place = 'inactive';
        }
        
        return \View::make('admin/substitutions/edit', array('users' => $users, 'stores' => $stores, 'substitution' => $substitution, 'place' => $place));
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
        $substitution = UserSubstitution::find($userSubstitution);
        if($substitution){
            $validator = Validator::make( $request->all(), [
                'user' => 'required',
                'store' => 'required',
                'dateFrom' => 'required',
                'dateTo' => 'required',
             ]);
            
            if ($validator->fails()) {
                return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
            }

            $place = 'active';
            $substitution->user_id = $request->user;
            $substitution->store_id = $request->store;
            $substitution->date_from = date('Y-m-d', strtotime($request->dateFrom));
            $substitution->date_to = date('Y-m-d', strtotime($request->dateTo));

            if($substitution->date_to < date("Y-m-d")){
                $place = 'inactive';
            }

    
            $substitution->save();
    
            return Response::json(array('ID' => $substitution->id, 'table' => View::make('admin/substitutions/table',array('substitution'=>$substitution))->render(), 'place' => $place));
        }
    }

    public function setStore(){
        $substitution = UserSubstitution::where([
            ['user_id', '=', Auth::user()->id],
            ['date_to', '>=', date("Y-m-d")]
        ])->first();

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
        $substitution = UserSubstitution::find($userSubstitution);
        
        if($substitution){
            $substitution->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
