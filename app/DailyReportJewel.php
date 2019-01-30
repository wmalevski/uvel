<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyReportJewel extends Model
{
    public function material(){
        return $this->belongsTo('App\MaterialQuantity');
    }
}
