<?php

namespace App\Http\Controllers;

use App\Nomenclatures;
use Illuminate\Http\Request;

class NomenclaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nomenclatures = Nomenclatures::all();

        return \View::make('nomenclatures/index', array('nomenclatures' => $nomenclatures));
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
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
            'color' => 'required',
        ]);

        $nomenclatures = Nomenclatures::create($request->all());
        return redirect('admin/nomenclatures');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Nomenclatures  $nomenclatures
     * @return \Illuminate\Http\Response
     */
    public function show(Nomenclatures $nomenclatures)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nomenclatures  $nomenclatures
     * @return \Illuminate\Http\Response
     */
    public function edit(Nomenclatures $nomenclatures)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nomenclatures  $nomenclatures
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nomenclatures $nomenclatures)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nomenclatures  $nomenclatures
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nomenclatures $nomenclatures)
    {
        //
    }
}
