<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoPhones extends Model
{
    protected $fillable = [
        'phone',
        'title'
    ];

    protected $table = 'info_phones';
}
