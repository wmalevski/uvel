<?php

namespace App\Http\Controllers;

use App\Stones;
use App\Stone_styles;
use App\Stone_contours;
use App\Stone_sizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Support\Facades\View;
use Uuid;
use App\Gallery;


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

        $file_data = $request->input('images'); 
        foreach($file_data as $img){
            $file_name = 'productimage_'.uniqid().time().'.png';
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
            file_put_contents(public_path('uploads/stones/').$file_name, $data);

            $photo = new Gallery();
            $photo->photo = $file_name;
            $photo->row_id = $stone->id;
            $photo->table = 'stones';

            $photo->save();
        }

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
    public function edit(Stones $stones, $stone)
    {
        $stone = Stones::find($stone);
        $stone_sizes = Stone_sizes::all();
        $stone_contours = Stone_contours::all();
        $stone_styles = Stone_styles::all();
        
        return \View::make('admin/stones/edit', array('stone' => $stone, 'stone_sizes' => $stone_sizes, 'stone_contours' => $stone_contours, 'stone_styles' => $stone_styles));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stones  $stones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stones $stones, $stone)
    {
        $stone = Stones::find($stone);
        $stone->name = $request->name;
        $stone->weight = $request->weight;
        $stone->carat = $request->carat;
        $stone->contour = $request->contour;
        $stone->style = $request->style;
        $stone->size = $request->size;
        $stone->amount = $request->amount;
        $stone->price = $request->price;

        $stone->save();

        return Response::json(array('table' => View::make('admin/stones/table',array('stone'=>$stone))->render()));
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
