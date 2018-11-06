<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelOrder extends Model
{
    //

    public function model()
    {
        return $this->belongsTo('App\Model');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
