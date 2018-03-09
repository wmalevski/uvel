<?php

namespace App\Http\Controllers;

use App\Repairs;
use Illuminate\Http\Request;
use App\Repair_types;

class RepairsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repairTypes = Repair_types::all();
        
        return \View::make('admin/repairs/index', array('repairTypes' => $repairTypes));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Repairs  $repairs
     * @return \Illuminate\Http\Response
     */
    public function show(Repairs $repairs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Repairs  $repairs
     * @return \Illuminate\Http\Response
     */
    public function edit(Repairs $repairs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Repairs  $repairs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Repairs $repairs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Repairs  $repairs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repairs $repairs)
    {
        //
    }
}
