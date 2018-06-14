<?php

namespace App\Http\Controllers;

use App\Materials;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Jewels;
use App\Materials_type;

class MaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $materials = Materials::all();
        $parents = Materials_type::all();
        
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
            'parent' => 'nullable|numeric'
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $material = Materials::create($request->all());

        return Response::json(array('success' => View::make('admin/materials/table',array('material'=>$material))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function show(Materials $materials)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function edit(Materials $materials, $material)
    {
        $material = Materials::find($material);
        $parents = Materials_type::all();

        //return Response::json(array('success' => View::make('admin/materials/edit',array('material'=>$material))->render()));
        return \View::make('admin/materials/edit',array('material'=>$material, 'parents' => $parents));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Materials $materials, $material)
    {
        $material = Materials::find($material);
        
        $material->code = $request->code;
        $material->color = $request->color;
        $material->carat = $request->carat;
        $material->parent = $request->parent;
        
        $material->save();

        return Response::json(array('ID' => $material->id,'table' => View::make('admin/materials/table',array('material'=>$material))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materials $materials, $material)
    {
        $material = Materials::find($material);
        
        if($material){
            $using = Jewels::where('material', $material->id)->count();
            
            if($using){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{
                $material->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
