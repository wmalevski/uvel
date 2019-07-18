<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\User;

class DiscountCode extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'discount',
        'expires',
        'user_id',
        'barcode',
        'lifetime',
        'active'
    ];

    protected $table = 'discount_codes';
    protected $dates = ['deleted_at'];

    public function check($barcode){
        $discount = DiscountCode::where('barcode', $barcode)->first();
        
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

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function payments()
    {
        return $this->hasMany('App\PaymentDiscount')->get();
    }

    public function filterDiscountCodes(Request $request ,$query){
        $query = DiscountCode::where(function($query) use ($request){
            if ($request->byUser) {
                $query->with('User')->whereHas('User', function($q) use ($request){
                    $q->where('name', 'LIKE', "%$request->byUser%");
                });
            }

            if($request->byBarcode){
                $query = $query->whereIn('barcode', [$request->byBarcode]);
            }

            if($request->byName == '' && $request->byBarcode == ''){
                $query = DiscountCode::all();
            }
        });

        return $query;
    }
}
