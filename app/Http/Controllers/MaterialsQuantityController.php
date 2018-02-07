<?php

namespace App\Http\Controllers;

use Auth;
use App\Materials_quantity;
use App\Materials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;

class MaterialsQuantityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = Materials_quantity::where('store', Auth::user()->store)->get();
        $materials_types = Materials::all();
        
        return \View::make('admin/materials_quantity/index', array('materials' => $materials, 'types' => $materials_types));
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
            'material' => 'required',
            'quantity' => 'required',
            'carat' => 'required',
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $material = Materials_quantity::create($request->all());

        return Response::json(array('success' => View::make('admin/materials_quantity/table',array('material'=>$material))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Materials_quantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function show(Materials_quantity $materials_quantity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Materials_quantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function edit(Materials_quantity $materials_quantity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materials_quantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Materials_quantity $materials_quantity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materials_quantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materials_quantity $materials_quantity)
    {
        //
    }
}
