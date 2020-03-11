<?php

namespace App\Http\Controllers;

use App\Gallery;
use File;
use Response;
use Storage;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::all();

        return view('admin.sliders.index', compact('sliders'));
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
            'images' => 'required',
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        
        $slider = Slider::create($request->all());

        $path = public_path('uploads/slides/');
        
        File::makeDirectory($path, 0775, true, true);
        Storage::disk('public')->makeDirectory('slides', 0775, true);

        $file_data = $request->input('images');
        if($file_data){
            foreach($file_data as $img){
                $file_name = 'slideimage_'.uniqid().time().'.png';
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                file_put_contents(public_path('uploads/slides/').$file_name, $data);

                Storage::disk('public')->put('sliders/'.$file_name, file_get_contents(public_path('uploads/slides/').$file_name));

                $photo = new Gallery();
                $photo->photo = $file_name;
                $slider->photo = $file_name;
                $slider->save();

                 $photo->slider_id = $slider->id;
                 $photo->table = 'sliders';

                 $photo->save();
            }
        }

        return Response::json(array('success' => View::make('admin/sliders/table',array('slide'=>$slider))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return \View::make('admin/sliders/edit', array('slider' => $slider));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $validator = Validator::make( $request->all(), [
            'images' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }


        $path = public_path('uploads/slides/');

        File::makeDirectory($path, 0775, true, true);
        Storage::disk('public')->makeDirectory('slides', 0775, true);

        $file_data = $request->input('images');
        if($file_data){
            foreach($file_data as $img){
                $file_name = 'slideimage_'.uniqid().time().'.png';
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                file_put_contents(public_path('uploads/slides/').$file_name, $data);

                Storage::disk('public')->put('sliders/'.$file_name, file_get_contents(public_path('uploads/slides/').$file_name));

                $slider->photo = $file_name;
            }
        }

        $slider->title = $request->title;
        $slider->content = $request->content;
        $slider->button_text = $request->button_text;
        $slider->button_link = $request->button_link;
        $slider->save();

        return Response::json(array('ID' => $slider->id, 'table' =>  View::make('admin/sliders/table',array('slide' => $slider))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        if($slider){
            $slider->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
