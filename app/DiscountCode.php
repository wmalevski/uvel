<?php

namespace App;

use App\User;
use App\UserGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class DiscountCode extends Model{
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
    protected $casts = ['deleted_at'];

    public function check($barcode){
        $discount = DiscountCode::with(['users', 'group'])->where('barcode', $barcode)->first();
        $bool = false;
        if($discount){
            if($discount->expires != ''){
                if($discount->expires >= date('dd-mm-yyyy') && $discount->active == 'yes'){
                    $bool = true;
                }else{
                    $bool = false;
                }
            }else{
                if($discount->active == 'yes'){
                    $bool = true;
                }
            }
        }

        return $discount ?? false;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function group() : BelongsTo
    {
        return $this->belongsTo(UserGroup::class, 'group_id');
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'discountcode_user');
    }

    public function payments()
    {
        return $this->hasMany('App\PaymentDiscount');
    }

    public static function filterDiscountCodes(Request $request, $query){
        $query = DiscountCode::where(function($query) use ($request){
            if($request->input('byUser')){
                $query->with('user')->whereHas('user', function($q) use ($request){
                    $q->where('email', 'LIKE', "%".$request->input('byUser')."%");
                });
            }

            if($request->input("byBarcode")){
                $query->whereRaw('barcode LIKE "%'.$request->input("byBarcode").'%"');
            }

            if($request->input("byGroup")){
                $query->with('group')->whereHas('group', function($q) use ($request){
                    $q->where('name', 'LIKE', "%".$request->input('byGroup')."%");
                });
            }
        });

        return $query;
    }
}
