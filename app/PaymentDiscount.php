<?php

namespace App;
use App\DiscountCode;

use Illuminate\Database\Eloquent\Model;

class PaymentDiscount extends Model
{
    public function discountCode(){
        return $this->belongsTo('App\DiscountCode');
    }
}
