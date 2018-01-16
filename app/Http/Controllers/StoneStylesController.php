<?php

namespace App\Http\Controllers;

use App\Stone_styles;
use Illuminate\Http\Request;

class StoneStylesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $styles = Stone_styles::all();

        return \View::make('stone_styles/index', array('styles' => $styles));
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
            'name' => 'required|unique:stone_styles',
        ]);

        $style = Stone_styles::create($request->all());
        return redirect('admin/stones/styles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stone_styles  $stone_styles
     * @return \Illuminate\Http\Response
     */
    public function show(Stone_styles $stone_styles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stone_styles  $stone_styles
     * @return \Illuminate\Http\Response
     */
    public function edit(Stone_styles $stone_styles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stone_styles  $stone_styles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stone_styles $stone_styles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stone_styles  $stone_styles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stone_styles $stone_styles)
    {
        //
    }
}
