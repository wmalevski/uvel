<?php

namespace App\Http\Controllers;

use App\Stores;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Stores::all();

        return \View::make('admin/stores/index', array('stores' => $stores));
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
            'location' => 'required',
            'phone' => 'required',
        ]);

        $store = Stores::create($request->all());
        return response()->json('vsi4ko s to4no');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function show(Stores $stores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function edit(Stores $stores, $store)
    {
        $store = Stores::find($store);
        
        return \View::make('stores/edit', array('store' => $store));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stores $stores, $store)
    {
        $store = Stores::find($store);
        
        $store->name = $request->name;
        $store->location = $request->location;
        $store->phone = $request->phone;
        
        $store->save();

        return \View::make('stores/edit', array('store' => $store));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stores $stores)
    {
        //
    }
}
