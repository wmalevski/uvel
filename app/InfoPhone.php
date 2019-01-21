<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoPhone extends Model
{
    protected $fillable = [
        'phone',
        'title'
    ];

    protected $table = 'info_phones';
}
