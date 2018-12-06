<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoMails extends Model
{
    protected $fillable = [
        'email',
        'title'
    ];

    protected $table = 'info_mails';
}
