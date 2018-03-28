<?php

namespace App\Http\Controllers;

use App\Repair_types;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class RepairTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repairTypes = Repair_types::all();
        
        return \View::make('admin/repair_types/index', array('repairTypes' => $repairTypes));
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

        $repairType = Repair_types::create($request->all());
        return Response::json(array('success' => View::make('admin/repair_types/table',array('repairType'=>$repairType))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Repair_types  $repairTypes
     * @return \Illuminate\Http\Response
     */
    public function show(Repair_types $repairTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Repair_types  $repairTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(Repair_types $repairTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Repair_types  $repairTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Repair_types $repairTypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RepairTypes  $repairTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repair_types $repairTypes)
    {
        //
    }
}
