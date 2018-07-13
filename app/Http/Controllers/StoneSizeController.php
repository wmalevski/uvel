<?php

namespace App\Http\Controllers;

use App\StoneSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Support\Facades\View;

class StoneSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = StoneSize::all();

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

        $size = new StoneSize();
        $response = $size->create($request->all());

        return Response::json(array('success' => View::make('admin/stone_sizes/table',array('size'=>$response))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StoneSize  $stoneSize
     * @return \Illuminate\Http\Response
     */
    public function show(StoneSize $stoneSize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StoneSize  $stoneSize
     * @return \Illuminate\Http\Response
     */
    public function edit(StoneSize $stoneSize)
    {
        $size = StoneSize::find($stoneSize);
        
        return \View::make('admin/stone_sizes/edit', array('size' => $size));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StoneSize  $stoneSize
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoneSize $stoneSize)
    {
        $size = StoneSize::find($stoneSize);
        
        $size->name = $request->name;
        
        $size->save();
        
        return Response::json(array('ID' => $size->id, 'table' => View::make('admin/stone_sizes/table', array('size' => $size))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StoneSize  $stoneSize
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoneSize $stoneSize)
    {
        $size = StoneSize::find($stoneSize);
        
        if($size){
            $size->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
