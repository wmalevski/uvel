<?php

namespace App\Http\Controllers;

use App\Stone_styles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Support\Facades\View;

class StoneStylesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $styles = Stone_styles::all();

        return \View::make('admin/stone_styles/index', array('styles' => $styles));
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
            'name' => 'required|unique:stone_styles',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $style = Stone_styles::create($request->all());
        return Response::json(array('success' => View::make('admin/stone_styles/table',array('style'=>$style))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stone_styles  $stone_styles
     * @return \Illuminate\Http\Response
     */
    public function show(Stone_styles $stone_styles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stone_styles  $stone_styles
     * @return \Illuminate\Http\Response
     */
    public function edit(Stone_styles $stone_styles, $style)
    {
        $style = Stone_styles::find($style);

        return \View::make('admin/stone_styles/edit', array('style' => $style));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stone_styles  $stone_styles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stone_styles $stone_styles, $style)
    {
        $style = Stone_styles::find($style);
        
        $style->name = $request->name;
        
        $style->save();
        
        return Response::json(array('ID' => $style->id, 'table' => View::make('admin/stone_styles/table', array('style' => $style))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stone_styles  $stone_styles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stone_styles $stone_styles, $style)
    {
        $style = Stone_styles::find($style);
        
        if($style){
            $style->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
