<?php

namespace App\Http\Controllers;

use App\Nomenclature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Response;

class NomenclatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nomenclatures = Nomenclature::all();

        return view('admin.nomenclatures.index', compact('nomenclatures'));
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

        $nomenclature = Nomenclature::create($request->all());

        return Response::json(array('success' => View::make('admin/nomenclatures/table',array('nomenclature'=>$nomenclature))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Nomenclatures  $nomenclatures
     * @return \Illuminate\Http\Response
     */
    public function show(Nomenclature $nomenclature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nomenclatures  $nomenclatures
     * @return \Illuminate\Http\Response
     */
    public function edit(Nomenclature $nomenclature)
    {
        return \View::make('admin/nomenclatures/edit', array('nomenclature' => $nomenclature));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nomenclatures  $nomenclatures
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nomenclature $nomenclature)
    {
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $nomenclature->name = $request->name;
        
        $nomenclature->save();
        
        return Response::json(array('ID' => $nomenclature->id, 'table' => View::make('admin/nomenclatures/table', array('nomenclature' => $nomenclature))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nomenclatures  $nomenclatures
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nomenclature $nomenclature)
    {
        if($nomenclature){
            if($nomenclature->stones->count()){
                return Response::json(['errors' => ['using' => ['Този контур се използва от системата и не може да бъде изтрит.']]], 401);
            }else {
                $nomenclature->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
