<?php

namespace App\Http\Controllers\Store;
use App\Blog;
use App\MaterialType;
use App\ProductOtherType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Blog::all();

        return \View::make('store.pages.blog.index', array('articles' => $articles));
    }

    public function show($article){
        $article = Blog::where('slug', $article)->first();
        if($article){
            return \View::make('store.pages.blog.single', array('article' => $article));
        }
    }

}
