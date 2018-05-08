<?php

namespace App\Http\Controllers;

use App\Jewels;
use App\Stones;
use App\Materials;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class JewelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jewels = Jewels::all();
        $materials = Materials::all();

        return view('admin.jewels.index', compact('jewels', 'materials'));
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
            'material' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $jewel = Jewels::create($request->all());
        $material = Materials::find($jewel->material);

        return Response::json(array('success' => View::make('admin/jewels/table',array('jewel'=>$jewel, 'material'=>$material))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jewels  $jewels
     * @return \Illuminate\Http\Response
     */
    public function show(Jewels $jewels)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jewels  $jewels
     * @return \Illuminate\Http\Response
     */
    public function edit(Jewels $jewels, $jewel)
    {
        $jewel = Jewels::find($jewel);
        $materials = Materials::all();
        
        //return Response::json(array('success' => View::make('admin/jewels/edit',array('jewel'=>$jewel, 'materials'=>$materials))->render()));
        return \View::make('admin/jewels/edit',array('jewel'=>$jewel, 'materials'=>$materials));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jewels  $jewels
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jewels $jewels, $jewel)
    {
        $jewel = Jewels::find($jewel);
        $materials = Materials::all();
        
        $jewel->name = $request->name;
        $jewel->material = $request->material;
        
        $jewel->save();

        return Response::json(array('table' => View::make('admin/jewels/table',array('jewel'=>$jewel, 'materials'=>$materials))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jewels  $jewels
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jewels $jewels, $jewel)
    {
        $jewel = Jewels::find($jewel);
        
        if($jewel){
            $jewel->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
