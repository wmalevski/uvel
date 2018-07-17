<?php

namespace App\Http\Controllers;

use App\Jewel;
use App\Stone;
use App\Material;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use File;
use App\Model;
use App\Product;

class JewelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jewels = Jewel::all();

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
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $jewel = Jewel::create($request->all());

        return Response::json(array('success' => View::make('admin/jewels/table',array('jewel'=>$jewel))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jewel  $jewels
     * @return \Illuminate\Http\Response
     */
    public function show(Jewel $jewel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jewel  $jewels
     * @return \Illuminate\Http\Response
     */
    public function edit(Jewel $jewel)
    {
        return \View::make('admin/jewels/edit',array('jewel'=>$jewel));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jewel  $jewels
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jewel $jewel)
    {
        $jewel->name = $request->name;
        
        $jewel->save();

        return Response::json(array('ID' => $jewel->id, 'table' => View::make('admin/jewels/table',array('jewel'=>$jewel))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jewel  $jewels
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jewel $jewel)
    {
        if($jewel){
            $usingModel = Product::where('jewel_type', $jewel->id)->count();
            $usingProduct = Model::where('jewel', $jewel->id)->count();

            if($usingModel || $usingProduct){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{
                $jewel->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
