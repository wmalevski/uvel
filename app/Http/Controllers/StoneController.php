<?php

namespace App\Http\Controllers;

use App\Stone;
use App\StoneStyle;
use App\StoneContour;
use App\StoneSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Support\Facades\View;
use Uuid;
use App\Gallery;
use File;
use App\ModelStone;
use App\ProductStone;


class StoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stones = Stone::all();
        $stone_sizes = StoneSize::all();
        $stone_contours = StoneContour::all();
        $stone_styles = StoneStyle::all();
        
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
            'weight' => 'required|numeric|between:0.01,100000',
            'carat' => 'required|numeric',
            'size' => 'required|numeric',
            'style' => 'required',
            'contour' => 'required',
            'price' => 'required|numeric|regex:/^\d*(\.\d{1,3})?$/',
            'amount' => 'required|numeric|between:0.01,100000'
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $stone = Stone::create($request->all());

        $path = public_path('uploads/stones/');
        
        File::makeDirectory($path, 0775, true, true);

        $file_data = $request->input('images'); 
        foreach($file_data as $img){
            $file_name = 'productimage_'.uniqid().time().'.png';
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
            file_put_contents(public_path('uploads/stones/').$file_name, $data);

            $photo = new Gallery();
            $photo->photo = $file_name;
            $photo->stone_id = $stone->id;
            $photo->table = 'stones';

            $photo->save();
        }

        return Response::json(array('success' => View::make('admin/stones/table',array('stone'=>$stone))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stone  $stone
     * @return \Illuminate\Http\Response
     */
    public function show(Stone $stone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stone  $stone
     * @return \Illuminate\Http\Response
     */
    public function edit(Stone $stone)
    {
        $stone = Stone::find($stone)->first();
        $stone_sizes = StoneSize::all();
        $stone_contours = StoneContour::all();
        $stone_styles = StoneStyle::all();
        $stone_photos = Gallery::where(
            [
                ['table', '=', 'stones'],
                ['stone_id', '=', $stone->id]
            ]
        )->get();
        
        return \View::make('admin/stones/edit', array('stone' => $stone, 'stone_sizes' => $stone_sizes, 'stone_contours' => $stone_contours, 'stone_styles' => $stone_styles, 'stone_photos' => $stone_photos));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stone  $stone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stone $stone)
    {
        $stone = Stone::find($stone)->first();

        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'type' => 'required',
            'weight' => 'required|numeric|between:0.01,100000',
            'carat' => 'required|numeric',
            'size' => 'required|numeric',
            'style' => 'required',
            'contour' => 'required',
            'price' => 'required|numeric|regex:/^\d*(\.\d{1,3})?$/',
            'amount' => 'required|numeric|between:0.01,100000'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $stone->name = $request->name;
        $stone->weight = $request->weight;
        $stone->carat = $request->carat;
        $stone->contour = $request->contour;
        $stone->style = $request->style;
        $stone->size = $request->size;
        $stone->amount = $request->amount;
        $stone->price = $request->price;

        $stone->save();

        $file_data = $request->input('images'); 

        $path = public_path('uploads/stones/');
        
        File::makeDirectory($path, 0775, true, true);

        foreach($file_data as $img){
            $file_name = 'stoneimage_'.uniqid().time().'.png';
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
            file_put_contents(public_path('uploads/stones/').$file_name, $data);

            $photo = new Gallery();
            $photo->photo = $file_name;
            $photo->stone_id = $stone->id;
            $photo->table = 'stones';

            $photo->save();
        }

        $stone_photos = Gallery::where(
            [
                ['table', '=', 'stones'],
                ['stone_id', '=', $stone->id]
            ]
        )->get();

        $photosHtml = '';

        foreach($stone_photos as $photo){
            $photosHtml .= '
                <div class="image-wrapper">
                <div class="close"><span data-url="gallery/delete/'.$photo->id.'">&#215;</span></div>
                <img src="'.asset("uploads/stones/" . $photo->photo).'" alt="" class="img-responsive" />
            </div>';
        }

        return Response::json(array('ID' => $stone->id, 'table' => View::make('admin/stones/table',array('stone'=>$stone))->render(), 'photos' => $photosHtml));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stone  $stone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stone $stone)
    {
        $stone = Stone::find($stone)->first();;
        
        if($stone){
            $usingModel = ModelStone::where('stone', $stone->id)->count();
            $usingProduct = ProductStone::where('stone', $stone->id)->count();

            if($usingModel || $usingProduct){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{
                $stone->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
