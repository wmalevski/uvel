<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'type_id',
        'amount',
        'currency_id',
        'user_id',
        'store_id',
        'additional_info'
    ];

    protected $table = 'expenses';

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
