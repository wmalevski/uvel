<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Selling extends Model
{
    public function repair(){
        return $this->belongsTo('App\Repair');
    }

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function product_other(){
        return $this->belongsTo('App\ProductOther');
    }
}
