<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Dimsav\Translatable\Translatable;

class Blog extends Model
{
    use Translatable;
    use SoftDeletes;

    protected $table = 'blogs';
    protected $dates = ['deleted_at'];

    public $translatedAttributes = [
        'title',
        'content',
        'excerpt'
    ];

    protected $fillable = [
        'thumbnail',
        'code'
    ];

    public function comments()
    {
        return $this->hasMany('App\BlogComment')->get();
    }

    public function author()
    {
        return $this->belongsTo('App\User')->first();
    }
}