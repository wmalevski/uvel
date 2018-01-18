<?php

namespace App\Http\Controllers;

use App\Stones;
use App\Stone_styles;
use App\Stone_contours;
use App\Stone_sizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;


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
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'type' => 'required',
            'weight' => 'required|numeric',
            'carat' => 'required|numeric',
            'size' => 'required|numeric',
            'style' => 'required',
            'contour' => 'required',
            'price' => 'required',
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $stone = Stones::create($request->all());
        return Response::json(array('success' => View::make('admin/stones/table',array('stone'=>$stone))->render()));
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
