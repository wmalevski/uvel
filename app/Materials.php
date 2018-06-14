<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materials extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'color',
        'carat',
        'parent'
    ];

    protected $table = 'materials';
    protected $dates = ['deleted_at'];
}
