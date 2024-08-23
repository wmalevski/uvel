<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $fillable = [
        'comment',
        'blog_id',
        'author_id'
    ];

    protected $table = 'blog_comments';
    protected $casts = ['deleted_at'];

    public function blog()
    {
        return $this->belongsTo('App\Blog')->get();
    }

    public function author()
    {
        return $this->belongsTo('App\User')->first();
    }
}
