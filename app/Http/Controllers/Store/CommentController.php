<?php


namespace App\Http\Controllers\Store;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Auth;


class CommentController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            'content' => 'required|string|max:1500',
            'rating' => 'required|integer',
            'type'  => 'required|string'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->rating = $request->rating;
        $comment->user_id = Auth::user()->getId();

        if($request->type == 'product') {
            $comment->product_id = $request->product_id;
        }elseif($request->type == 'model') {
            $comment->model_id = $request->model_id;
        }elseif($request->type == 'product_other') {
            $comment->product_others_id = $request->product_others_id;
        }
        $comment->save();

        return Redirect::back()->with('success.review', 'Ревюто ви беше изпратено успешно');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
