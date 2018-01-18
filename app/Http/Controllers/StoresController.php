<?php

namespace App\Http\Controllers;

use App\Stores;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Response;

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

        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'location' => 'required',
            'phone' => 'required',
         ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $store = Stores::create($request->all());
        
        return response(view('admin.stores.table', compact('store')),200, ['Content-Type' => 'application/json']);
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
