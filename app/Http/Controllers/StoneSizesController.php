<?php

namespace App\Http\Controllers;

use App\Stone_sizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Support\Facades\View;

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

        return \View::make('admin/stone_sizes/index', array('sizes' => $sizes));
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
            'name' => 'required|unique:stone_sizes',
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $size = new Stone_sizes();
        $response = $size->create($request->all());

        return Response::json(array('success' => View::make('admin/stone_sizes/table',array('size'=>$response))->render()));
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
