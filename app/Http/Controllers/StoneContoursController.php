<?php

namespace App\Http\Controllers;

use App\Stone_contours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class StoneContoursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contours = Stone_contours::all();

        return \View::make('admin/stone_contours/index', array('contours' => $contours));
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
            'name' => 'required|unique:stone_contours',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $contour = Stone_contours::create($request->all());
        return response(view('admin.stones.table', compact('stone')),200, ['Content-Type' => 'application/json']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stone_contours  $stone_contours
     * @return \Illuminate\Http\Response
     */
    public function show(Stone_contours $stone_contours)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stone_contours  $stone_contours
     * @return \Illuminate\Http\Response
     */
    public function edit(Stone_contours $stone_contours)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stone_contours  $stone_contours
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stone_contours $stone_contours)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stone_contours  $stone_contours
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stone_contours $stone_contours)
    {
        //
    }
}
