<?php

namespace App\Http\Controllers;

use App\Jewels;
use App\Stones;
use App\Materials;
use Illuminate\Http\Request;

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
        $validatedData = $request->validate([
            'name' => 'required',
            'material' => 'required',
        ]);

        $jewels = Jewels::create($request->all());
        return redirect('admin/jewels');
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
        
        return \View::make('jewels/edit', array('jewel' => $jewel, 'materials' => $materials));
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

        return \View::make('jewels/edit', array('jewel' => $jewel, 'materials' => $materials));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jewels  $jewels
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jewels $jewels)
    {
        //
    }
}
