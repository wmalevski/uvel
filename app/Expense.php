<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public function type(){
        return $this->belongsTo('App\ExpenseType');
    }

    public function currency(){
        return $this->belongsTo('App\Currency');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function store(){
        return $this->belongsTo('App\Store');
    }
}
