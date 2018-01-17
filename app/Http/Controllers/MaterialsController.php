<?php

namespace App\Http\Controllers;

use App\Materials;
use Illuminate\Http\Request;

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
        
        
        return \View::make('admin/materials/index', array('materials' => $materials));
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
            'code' => 'required',
            'color' => 'required',
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $material = Materials::create($request->all());

        return Response::json([ 'html' => '
            <tr>
                <td></td>
                <td>'.$material->name.'</td> 
                <td>'.$material->code.'</td> 
                <td>'.$material->color.'</td> 
                <td><a href="materials/'.$request->id.'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
            </tr>
        '], 200);
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

        return \View::make('materials/edit', array('material' => $material));
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
        
        $material->name = $request->name;
        $material->code = $request->code;
        $material->color = $request->color;
        
        $material->save();

        return \View::make('materials/edit', array('material' => $material));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materials $materials)
    {
        //
    }
}
