<?php

namespace App\Http\Controllers;

use App\gallery;
use Illuminate\Http\Request;
use Response;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(gallery $gallery, $photo)
    {
        $photo = $gallery::find($photo);
        if (!$photo) {
            return Response::json(['errors' => ['using' => ['Не е налична снимка.']]], 401);
        }

        $countImagesModel = $photo->model_id ? $gallery::where('model_id', $photo->model_id)->count() : null;

        if ($countImagesModel === 1) {
            return Response::json(['errors' => ['using' => [trans('admin/models.model_edit_picture_error')]]], 401);
        } else {
            unlink(public_path('uploads\\' . $photo->table . '\\') . $photo->photo);
            $photo->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
