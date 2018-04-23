<?php

namespace App\Http\Controllers;

use App\Usersubstitutions;
use Illuminate\Http\Request;
use App\Stores;

class UsersubstitutionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $user)
    {
        $substitution = new Usersubstitutions();
        $substitution->user_id = $user;
        $substitution->store_id = $request->store;
        $substitution->date_from = $request->dateFrom;
        $substitution->date_to = $request->dateTo;

        $substitution->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Usersubstitutions  $usersubstitutions
     * @return \Illuminate\Http\Response
     */
    public function show(Usersubstitutions $usersubstitutions, $user)
    {
        $stores = Stores::all();

        $status = 0;

        $substitution = Usersubstitutions::where([
            ['user_id', '=', $user],
            ['date_to', '>=', date("dd-mm-yyyy")]
        ])->first();

        if($substitution){
            $status = 1;
        }

        if($status == 0){
            return \View::make('admin/users/substitutions', array('user' => $user, 'stores' => $stores));
        } else if($status == 1){
            return \View::make('admin/users/alreadysub', array('user' => $user, 'store' => $substitution->store_id, 'dateFrom' => $substitution->date_from, 'dateTo' => $substitution->date_to));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Usersubstitutions  $usersubstitutions
     * @return \Illuminate\Http\Response
     */
    public function edit(Usersubstitutions $usersubstitutions)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Usersubstitutions  $usersubstitutions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usersubstitutions $usersubstitutions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usersubstitutions  $usersubstitutions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usersubstitutions $usersubstitutions)
    {
        //
    }
}
