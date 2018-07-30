<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Jewel;
use App\MaterialType;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $materials = Material::all();
        $parents = MaterialType::all();
        
        return \View::make('admin/materials/index', array('materials' => $materials, 'parents' => $parents));
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
            'code' => 'required',
            'color' => 'required',
            'carat' => 'nullable|numeric|between:1,100',
            'parent_id' => 'required|nullable|numeric'
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $material = Material::create($request->all());

        return Response::json(array('success' => View::make('admin/materials/table',array('material'=>$material))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Material  $materials
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Material  $materials
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        $parents = MaterialType::all();

        return \View::make('admin/materials/edit',array('material'=>$material, 'parents' => $parents));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material  $materials
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        $validator = Validator::make( $request->all(), [
            'code' => 'required',
            'color' => 'required',
            'carat' => 'nullable|numeric|between:1,100',
            'parent_id' => 'required|nullable|numeric'
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $material->code = $request->code;
        $material->color = $request->color;
        $material->carat = $request->carat;
        $material->parent_id = $request->parent_id;
        
        $material->save();

        return Response::json(array('ID' => $material->id,'table' => View::make('admin/materials/table',array('material'=>$material))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material  $materials
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        if($material){
            $material->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
