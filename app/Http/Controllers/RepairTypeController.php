<?php

namespace App\Http\Controllers;

use App\RepairType;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class RepairTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repairTypes = RepairType::all();
        
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

        $repairType = RepairType::create($request->all());
        return Response::json(array('success' => View::make('admin/repair_types/table',array('repairType'=>$repairType))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RepairType  $repairTypes
     * @return \Illuminate\Http\Response
     */
    public function show(RepairType $repairType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RepairType  $repairTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(RepairType $repairType)
    {
        return \View::make('admin/repair_types/edit', array('repair' => $repairType));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RepairType  $repairTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RepairType $repairType)
    {
        $repairType->name = $request->name;
        $repairType->price = $request->price;

        $repairType->save();
        
        return Response::json(array('ID' => $repairType->id, 'table' => View::make('admin/repair_types/table',array('repairType'=>$repairType))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RepairType  $repairTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(RepairType $repairType)
    {
        if($repairType){
            $repairType->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
