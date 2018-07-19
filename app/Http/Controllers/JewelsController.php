<?php

namespace App\Http\Controllers;

use App\Jewels;
use App\Stones;
use App\Materials;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use File;
use App\Models;
use App\Product;

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

        return view('admin.jewels.index', compact('jewels'));
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
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $jewel = Jewels::create($request->all());

        return Response::json(array('success' => View::make('admin/jewels/table',array('jewel'=>$jewel))->render()));
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
        
        //return Response::json(array('success' => View::make('admin/jewels/edit',array('jewel'=>$jewel, 'materials'=>$materials))->render()));
        return \View::make('admin/jewels/edit',array('jewel'=>$jewel));
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
        
        $jewel->name = $request->name;
        
        $jewel->save();

        return Response::json(array('ID' => $jewel->id, 'table' => View::make('admin/jewels/table',array('jewel'=>$jewel))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jewels  $jewels
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jewels $jewels, $jewel)
    {
        $jewel = Jewels::find($jewel);
        
        if($jewel){
            $usingModel = Product::where('jewel_type', $jewel->id)->count();
            $usingProduct = Models::where('jewel', $jewel->id)->count();

            if($usingModel || $usingProduct){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{
                $jewel->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
