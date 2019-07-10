<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyReportCurrency extends Model
{
    public function currency(){
        return $this->belongsTo('App\Currency');
    }
}
