<?php

namespace App\Http\Controllers;

use App\Stones;
use App\Stone_styles;
use App\Stone_contours;
use App\Stone_sizes;
use Illuminate\Http\Request;

class StonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stones = Stones::all();
        $stone_sizes = Stone_sizes::all();
        $stone_contours = Stone_contours::all();
        $stone_styles = Stone_styles::all();
        
        return view('admin.stones.index', compact('stones', 'stone_sizes', 'stone_contours', 'stone_styles'));
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
            'type' => 'required',
            'weight' => 'required',
            'carat' => 'required',
            'size' => 'required',
            'style' => 'required',
            'contour' => 'required',
            'price' => 'required',
        ]);

        $stones = Stones::create($request->all());
        return redirect('admin/stones');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stones  $stones
     * @return \Illuminate\Http\Response
     */
    public function show(Stones $stones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stones  $stones
     * @return \Illuminate\Http\Response
     */
    public function edit(Stones $stones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stones  $stones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stones $stones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stones  $stones
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stones $stones)
    {
        //
    }
}
