<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use \Dimsav\Translatable\Translatable;

class BlogTranslation extends Model {
    
    public $timestamps = false;

    protected $fillable = [
        'title',
        'content',
        'excerpt'
    ];

}