<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materials extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'color',
        'carat'
    ];

    protected $table = 'materials';
    protected $dates = ['deleted_at'];
}
