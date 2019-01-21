<?php

namespace App\Http\Controllers;
use File;
use Storage;
use Response;
use Auth;
use App\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use App\BlogComment;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Blog::all();
        
        return view('admin.blog.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'title.*' => 'required',
            'content.*' => 'required',
            'images' => 'required',
            'excerpt.*' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $article = new Blog();
        $article->thumbnail = $request->images[0];
        $article->author_id = Auth::user()->getId();
        $article->slug = slugify($request->title['bg']);
        $article->save();
        
        $article->slug = $article->slug.'-'.$article->id;
        $article->save();

        foreach (config('translatable.locales') as $locale => $language) {
            $article->translateOrNew($locale)->title = $request->title[$locale];
            $article->translateOrNew($locale)->excerpt = $request->excerpt[$locale];
            $article->translateOrNew($locale)->content = $request->content[$locale];
        }

        $article->save();

        $path = public_path('uploads/blog/');
        
        File::makeDirectory($path, 0775, true, true);
        Storage::disk('public')->makeDirectory('blog', 0775, true);

        $file_data = $request->input('images'); 
        
        if($file_data){
            foreach($file_data as $img){
                $memi = substr($img, 5, strpos($img, ';')-5);

                $extension = explode('/',$memi);

                if($extension[1] == "svg+xml"){
                    $ext = 'png';
                }else{
                    $ext = $extension[1];
                }
                

                $file_name = 'productimage_'.uniqid().time().'.'.$ext;
            
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                file_put_contents(public_path('uploads/blog/').$file_name, $data);

                Storage::disk('public')->put('blog/'.$file_name, file_get_contents(public_path('uploads/blog/').$file_name));

                $article->thumbnail = $file_name;
                $article->save();
            }
        }

        return Response::json(array('success' => View::make('admin/blog/table',array('article'=>$article))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $article)
    {
        return \View::make('admin/blog/edit',array('article'=>$article));
    }

    /**s
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $article)
    {
        $validator = Validator::make( $request->all(), [
            'title.*' => 'required',
            'content.*' => 'required',
            'excerpt.*' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        foreach (config('translatable.locales') as $locale => $language) {
            $article->translateOrNew($locale)->title = $request->title[$locale];
            $article->translateOrNew($locale)->excerpt = $request->excerpt[$locale];
            $article->translateOrNew($locale)->content = $request->content[$locale];
        }

        $article->save();

        if($request->images){
            $article->thumbnail = $request->images[0];
        }

        $article->slug = $article->slug.'-'.$article->id;
        $article->save();

        $path = public_path('uploads/blog/');
        
        File::makeDirectory($path, 0775, true, true);
        //Storage::disk('public')->makeDirectory('blog', 0775, true);

        $file_data = $request->input('images'); 
        
        if($file_data){
            foreach($file_data as $img){
                $memi = substr($img, 5, strpos($img, ';')-5);

                $extension = explode('/',$memi);

                if($extension[1] == "svg+xml"){
                    $ext = 'png';
                }else{
                    $ext = $extension[1];
                }
                

                $file_name = 'productimage_'.uniqid().time().'.'.$ext;
            
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
                file_put_contents(public_path('uploads/blog/').$file_name, $data);

                Storage::disk('public')->put('blog/'.$file_name, file_get_contents(public_path('uploads/blog/').$file_name));

                $article->thumbnail = $file_name;
                $article->save();
            }
        }

        return Response::json(array('ID' => $article->id, 'table' => View::make('admin/blog/table',array('article'=>$article))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        if($blog){
            $blog->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }

    public function showComments(Blog $article)
    {
        $comments = $article->comments();

        return view('admin.blog.comments.index', compact('comments'));
    }
}
