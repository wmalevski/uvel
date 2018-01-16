<?php

namespace App\Http\Controllers;

use App\Stone_sizes;
use Illuminate\Http\Request;

class StoneSizesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Stone_sizes::all();

        return \View::make('stone_sizes/index', array('sizes' => $sizes));
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
            'name' => 'required|unique:stone_sizes',
        ]);

        $size = Stone_sizes::create($request->all());
        return redirect('admin/stones/sizes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stone_sizes  $stone_sizes
     * @return \Illuminate\Http\Response
     */
    public function show(Stone_sizes $stone_sizes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stone_sizes  $stone_sizes
     * @return \Illuminate\Http\Response
     */
    public function edit(Stone_sizes $stone_sizes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stone_sizes  $stone_sizes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stone_sizes $stone_sizes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stone_sizes  $stone_sizes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stone_sizes $stone_sizes)
    {
        //
    }
}
