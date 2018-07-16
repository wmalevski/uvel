<?php

namespace App\Http\Controllers;

use App\ModelOption;
use Illuminate\Http\Request;

class ModelOptionsController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ModelOptions  $modelOptions
     * @return \Illuminate\Http\Response
     */
    public function show(ModelOption $modelOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ModelOptions  $modelOptions
     * @return \Illuminate\Http\Response
     */
    public function edit(ModelOption $modelOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ModelOptions  $modelOptions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModelOption $modelOption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ModelOptions  $modelOptions
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelOption $modelOption)
    {
        $option = ModelOption::find($modelOption);
        
        if($option){
            $option->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
