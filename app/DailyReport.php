<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    public function store(){
        return $this->belongsTo('App\Store')->withTrashed();
    }

    public function user(){
        return $this->belongsTo('App\User')->withTrashed();
    }
}
