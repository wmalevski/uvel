<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'corporate_partners';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
