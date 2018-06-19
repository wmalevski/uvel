<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usersubstitutions extends Model
{
    use SoftDeletes;

    protected $dates = ['date_from', 'date_to', 'deleted_at'];
}
