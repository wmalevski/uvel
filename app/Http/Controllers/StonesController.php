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
use File;
use App\Model_stones;
use App\Product_stones;


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

        $stone = Stones::create($request->all());

        $path = public_path('uploads/stones/');
        
        File::makeDirectory($path, 0775, true, true);

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
        $stone_photos = Gallery::where(
            [
                ['table', '=', 'stones'],
                ['row_id', '=', $stone->id]
            ]
        )->get();
        
        return \View::make('admin/stones/edit', array('stone' => $stone, 'stone_sizes' => $stone_sizes, 'stone_contours' => $stone_contours, 'stone_styles' => $stone_styles, 'stone_photos' => $stone_photos));
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
            $photo->row_id = $stone->id;
            $photo->table = 'stones';

            $photo->save();
        }

        $stone_photos = Gallery::where(
            [
                ['table', '=', 'stones'],
                ['row_id', '=', $stone->id]
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
     * @param  \App\Stones  $stones
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stones $stones, $stone)
    {
        $stone = Stones::find($stone);
        
        if($stone){
            $usingModel = Model_stones::where('stone', $stone->id)->count();
            $usingProduct = Product_stones::where('stone', $stone->id)->count();

            if($usingModel || $usingProduct){
                return Response::json(['errors' => ['using' => ['Този елемент се използва от системата и не може да бъде изтрит.']]], 401);
            }else{
                $stone->delete();
                return Response::json(array('success' => 'Успешно изтрито!'));
            }
        }
    }
}
