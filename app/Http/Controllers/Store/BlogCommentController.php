<?php

namespace App\Http\Controllers\Store;
use Auth;
use Response;
use App\BlogComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class BlogCommentController extends Controller
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
    public function store(Request $request, $article)
    {
        $validator = Validator::make( $request->all(), [
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $comment = new BlogComment();
        $comment->comment = $request->comment;
        $comment->blog_id = $article;
        $comment->author_id = Auth::user()->getId();
        $comment->save();

        return Redirect::back();

        //return Response::json(array('ID' => $comment->id, 'table' => View::make('store/blog/comment',array('comment'=>$comment))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BlogComment  $blogComment
     * @return \Illuminate\Http\Response
     */
    public function show(BlogComment $blogComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BlogComment  $blogComment
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogComment $blogComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BlogComment  $blogComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogComment $blogComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlogComment  $blogComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogComment $comment)
    {
        if($comment){
            $comment->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
