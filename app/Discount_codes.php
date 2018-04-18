<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount_codes extends Model
{
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

    public function check($barcode){
        $discount = Discount_codes::where('barcode', $barcode)->first();
        
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
