<?php

namespace App\Http\Controllers;

use Auth;
use App\MaterialQuantity;
use App\Material;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;
use App\MaterialTravelling;

class MaterialQuantityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$materials = Materials_quantity::where('store', Auth::user()->store)->get();
        //$stores = Store::where('id', '!=', Auth::user()->store)->get();
        $materials = MaterialQuantity::all();
        $stores = Store::all();
        $materials_types = Material::all();
        $travelling = MaterialTravelling::where('storeFrom', Auth::user()->store)->orWhere('storeTo', Auth::user()->store)->get();
        
        return \View::make('admin/materials_quantity/index', array('materials' => $materials, 'types' => $materials_types, 'stores' => $stores, 'travelling' => $travelling));
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
            'store' => 'required'
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $material = MaterialQuantity::create($request->all());

        return Response::json(array('success' => View::make('admin/materials_quantity/table',array('material'=>$material))->render()));
    }

    public function sendMaterial(Request $request){
        return Response::json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaterialQuantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialQuantity $materialQuantity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaterialQuantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialQuantity $materialQuantity)
    {
        $stores = Store::all();
        $materials_types = Material::withTrashed()->get();
        
        return \View::make('admin/materials_quantity/edit',array('material'=>$materialQuantity, 'types' => $materials_types, 'stores' => $stores));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaterialQuantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialQuantity $materialQuantity)
    {
        $materialQuantity->material = $request->material;
        $materialQuantity->quantity = $request->quantity;
        $materialQuantity->store = $request->store;

        $validator = Validator::make( $request->all(), [
            'material' => 'required',
            'quantity' => 'required',
            'store' => 'required'
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }
        
        $materialQuantity->save();
        
        return Response::json(array('ID' => $materialQuantity->id, 'table' => View::make('admin/materials_quantity/table', array('material' => $materialQuantity))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaterialQuantity  $materials_quantity
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialQuantity $materialQuantity)
    {
        $material = MaterialQuantity::find($materialQuantity)->first();
        
        if($material){
            $material->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }

    public function deleteByMaterial($material){
        MaterialQuantity::where('material', $material)->delete();
        return Response::json(array('success' => 'Успешно изтрито!'));
    }
}