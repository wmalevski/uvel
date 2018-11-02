<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'thumbnail',
        'title',
        'content',
        'excerpt'
    ];

    protected $table = 'blogs';
    protected $dates = ['deleted_at'];

    public function comments()
    {
        return $this->hasMany('App\BlogComment')->get();
    }

    public function author()
    {
        return $this->belongsTo('App\User')->first();
    }
}
