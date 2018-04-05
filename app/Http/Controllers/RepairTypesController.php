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
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'price' => 'required|numeric|between:0.1,50000',
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

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
    public function edit(Repair_types $repairTypes, $type)
    {
        $type = Repair_types::find($type);

        return \View::make('admin/repair_types/edit', array('repair' => $type));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Repair_types  $repairTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Repair_types $repairTypes, $type)
    {
        $type = Repair_types::find($type);
        $type->name = $request->name;
        $type->price = $request->price;

        $type->save();
        
        return Response::json(array('table' => View::make('admin/repair_types/table',array('repairType'=>$type))->render()));
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
