<?php

namespace App\Http\Controllers;

use App\Materials_travelling;
use App\Materials_quantity;
use App\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;
use Auth;
use Illuminate\Support\Facades\View;

class MaterialsTravellingController extends Controller
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
    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'type' => 'required',
            'quantity' => 'required',
            'storeTo' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $check = Materials_quantity::find($request->type);

        if($check){
            if($request->quantity <= $check->quantity){
                $material = new Materials_travelling();
                $material->type = $request->type;
                $material->quantity = $request->quantity;
                $material->price = '12';
                $material->storeFrom = Auth::user()->store;
                $material->storeTo  = $request->storeTo;
                $material->dateSent = new \DateTime();
                $material->userSent = Auth::user()->id;

                $material->save();

                $quantity = Materials_quantity::find($request->type);

                if($quantity){
                    $quantity->quantity = $quantity->quantity - $request->quantity;
                    $quantity->save();
                }

                $history = new History();

                $history->action = '1';
                $history->user = Auth::user()->id;
                $history->table = 'materials_travelling';
                $history->result_id = $material->id;

                $history->save();
                //return Response::json(array('success' => View::make('admin/materials_travelling/table',array('material'=>$material))->render()))
            }else{
                return Response::json(['errors' => array('quantity' => ['Въведохте невалидно количество!'])], 401);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Materials_travelling  $materials_travelling
     * @return \Illuminate\Http\Response
     */
    public function show(Materials_travelling $materials_travelling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Materials_travelling  $materials_travelling
     * @return \Illuminate\Http\Response
     */
    public function edit(Materials_travelling $materials_travelling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materials_travelling  $materials_travelling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Materials_travelling $materials_travelling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materials_travelling  $materials_travelling
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materials_travelling $materials_travelling)
    {
        //
    }
}
