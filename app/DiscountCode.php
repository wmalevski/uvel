<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountCode extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'discount',
        'expires',
        'user',
        'code',
        'barcode',
        'lifetime',
        'active'
    ];

    protected $table = 'discount_codes';
    protected $dates = ['deleted_at'];

    public function check($barcode){
        $discount = DiscountCodes::where('barcode', $barcode)->first();
        
        if($discount){
            if($discount->expires != ''){
                if($discount->expires >= date('dd-mm-yyyy') && $discount->active == 'yes'){
                    return true;
                }else{
                    return false;
                }
            }else{
                if($discount->active == 'yes'){
                    return true;
                }
            }
        }else{
            return false;
        }
    }

}
