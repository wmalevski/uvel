<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoMail extends Model
{
    protected $fillable = [
        'email',
        'title'
    ];

    protected $table = 'info_mails';
}
