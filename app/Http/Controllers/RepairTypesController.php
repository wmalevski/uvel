<?php

namespace App\Http\Controllers;

use App\RepairTypes;
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
        $repairTypes = RepairTypes::all();
        
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

        $repairType = RepairTypes::create($request->all());
        return Response::json(array('success' => View::make('admin/repair_types/table',array('repairType'=>$repairType))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RepairTypes  $repairTypes
     * @return \Illuminate\Http\Response
     */
    public function show(RepairTypes $repairTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RepairTypes  $repairTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(RepairTypes $repairTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RepairTypes  $repairTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RepairTypes $repairTypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RepairTypes  $repairTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(RepairTypes $repairTypes)
    {
        //
    }
}
