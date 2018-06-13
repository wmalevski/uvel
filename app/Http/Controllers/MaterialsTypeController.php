<?php

namespace App\Http\Controllers;

use App\Materials_type;
use App\Jewels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Response;
use App\Materials;

class MaterialsTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = Materials_type::all();

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

        $material = Materials_type::create($request->all());

        return Response::json(array('success' => View::make('admin/materials_types/table',array('material'=>$material))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Materials_type  $materials_type
     * @return \Illuminate\Http\Response
     */
    public function show(Materials_type $materials_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Materials_type  $materials_type
     * @return \Illuminate\Http\Response
     */
    public function edit(Materials_type $materials_type, $material)
    {
        $material = Materials_type::find($material);

        return \View::make('admin/materials_types/edit',array('material'=>$material));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materials_type  $materials_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Materials_type $materials_type, $material)
    {
        $material = Materials_type::find($material);
        
        $material->name = $request->name;
        
        $material->save();

        return Response::json(array('ID' => $material->id,'table' => View::make('admin/materials_types/table',array('material'=>$material))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materials_type  $materials_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materials_type $materials_type, $material)
    {
        $material = Materials_type::find($material);
        
        if($material){
            $using = Materials::where('parent', $material->id)->count();
            
            if($using){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{
                $material->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
