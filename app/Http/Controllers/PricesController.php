<?php

namespace App\Http\Controllers;

use App\Prices;
use App\Materials;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $materials = Materials::all();
        

        if ($request->isMethod('post')){

            return redirect()->route('prices', ['material' => $request->material]);
        }

        return \View::make('admin/prices/index', array('materials' => $materials));
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
            'slug' => 'required',
            'price' => 'required',
            'type' => 'required',
        ]);

        $price = Prices::create($request->all());
        return redirect()->route('admin/prices', ['material' => $request->material]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prices  $prices
     * @return \Illuminate\Http\Response
     */
    public function show(Prices $prices, $material)
    {
        $material = Materials::find($material);

        if($material){
            $prices = Prices::where('material', $material->id)->get();

            return view('admin/prices/show', compact('prices', 'material'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prices  $prices
     * @return \Illuminate\Http\Response
     */
    public function edit(Prices $prices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prices  $prices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prices $prices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prices  $prices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prices $prices)
    {
        //
    }
}
