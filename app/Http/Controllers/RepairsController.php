<?php

namespace App\Http\Controllers;

use App\Repairs;
use Illuminate\Http\Request;
use App\Repair_types;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;

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
        $repairs = Repairs::all();
        
        return \View::make('admin/repairs/index', array('repairTypes' => $repairTypes, 'repairs' => $repairs));
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
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'type' => 'required',
            'date_returned' => 'required',
            'weight' => 'required',
            'phone' => 'required|numeric',
         ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }


        $repair = Repairs::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'type' => $request->type,
            'date_recieved' => $request->date_recieved,
            'date_returned' => $request->date_returned,
            'code' =>  unique_random('repairs', 'code', 4),
            'weight' => $request->weight,
            'repair_description' => $request->repair_description
        ]);
        
        $repair->barcode = '380'.unique_number('repairs', 'code', 7);

        $repair->save();

        return Response::json(array('success' => View::make('admin/repairs/table',array('repair'=>$repair))->render()));
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
