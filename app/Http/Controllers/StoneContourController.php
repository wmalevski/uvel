<?php

namespace App\Http\Controllers;

use App\StoneContour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Support\Facades\View;

class StoneContourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contours = StoneContour::all();

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

        $contour = StoneContour::create($request->all());
        return Response::json(array('success' => View::make('admin/stone_contours/table',array('contour'=>$contour))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stone_contours  $stone_contours
     * @return \Illuminate\Http\Response
     */
    public function show(StoneContour $stoneContour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stone_contours  $stone_contours
     * @return \Illuminate\Http\Response
     */
    public function edit(StoneContour $stoneContour)
    {
        return \View::make('admin/stone_contours/edit', array('contour' => $stoneContour));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stone_contours  $stone_contours
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoneContour $stoneContour)
    {
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $stoneContour->name = $request->name;
        
        $stoneContour->save();
        
        return Response::json(array('ID' => $stoneContour->id, 'table' => View::make('admin/stone_contours/table', array('contour' => $stoneContour))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stone_contours  $stone_contours
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoneContour $stoneContour)
    {
        if($stoneContour){
            if($stoneContour->stones->count()){
                return Response::json(['errors' => ['using' => ['Този контур се използва от системата и не може да бъде изтрит.']]], 401);
            }else {
                $stoneContour->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
