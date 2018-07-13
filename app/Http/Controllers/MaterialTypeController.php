<?php

namespace App\Http\Controllers;

use App\MaterialType;
use App\Jewel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Response;
use App\Material;

class MaterialTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = MaterialType::all();

        return \View::make('admin/materials_types/index', array('materials' => $materials));
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
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $material = MaterialType::create($request->all());

        return Response::json(array('success' => View::make('admin/materials_types/table',array('material'=>$material))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaterialType  $materials_type
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialType $materialType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaterialType  $materials_type
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialType $materialType)
    {
        $material = MaterialType::find($materialType)->first();

        return \View::make('admin/materials_types/edit',array('material'=>$material));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaterialType  $materials_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialType $materialType)
    {
        $material = MaterialType::find($materialType)->first();
        
        $material->name = $request->name;
        
        $material->save();

        return Response::json(array('ID' => $material->id,'table' => View::make('admin/materials_types/table',array('material'=>$material))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaterialType  $materials_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialType $materialType)
    {
        $material = MaterialType::find($materialType)->first();
        
        if($material){
            $using = Material::where('parent', $material->id)->count();
            
            if($using){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{
                $material->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
