<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $table = 'reviews';

    protected $fillable = [
        'title',
        'content',
        'rating',
        'user_id',
        'product_id',
        'model_id',
        'product_others_id'
    ];

    protected $dates = ['deleted_at'];

}
