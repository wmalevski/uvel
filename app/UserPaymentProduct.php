<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPaymentProduct extends Model
{

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function store() {
        return $this->belongsTo('App\Store');
    }

    public function payment() {
        return $this->belongsTo('App\Payment');
    }
}
