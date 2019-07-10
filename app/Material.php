<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Cart;
use Auth;

class Material extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'color',
        'carat',
        'parent_id',
        'cash_group'
    ];

    protected $table = 'materials';
    protected $dates = ['deleted_at'];

    public function parent(){
        return $this->belongsTo('App\MaterialType')->withTrashed();
    }

    public function quantity(){
        return $this->hasMany('App\MaterialQuantity')->withTrashed();
    }

    public function prices(){
        return $this->hasMany('App\Price')->withTrashed();
    }

    public function pricesBuy(){
        return $this->hasMany('App\Price')->where('type', 'buy');
    }

    public function pricesSell(){
        return $this->hasMany('App\Price')->where('type', 'sell');
    }

    public function products(){
        return $this->hasMany('App\Product');
    }

    public function productsOnline(){
        return $this->hasMany('App\Product')->where('status', 'available');
    }

    public function scopeForBuy()
    {
        return $this->where('for_buy', 'yes');
    }

    public function scopeForExchange()
    {
        return $this->where('for_exchange', 'yes');
    }

    public function filterMaterials(Request $request ,$query){
        $query = Material::where(function($query) use ($request){
            if($request->byCode){
                $query = $query->whereIn('code', [$request->byCode]);
            }

            if($request->byName){
                $request->byName = explode("-", $request->byName);

                $query->whereHas('parent', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . trim($request->byName[0]) . '%');
                });

                if (count($request->byName) > 1) {
                    $query->where('color', 'LIKE', '%' . trim($request->byName[1]) . '%');
                }

                if (count($request->byName) > 2) {
                    $query->where('code', 'LIKE', '%' . trim($request->byName[2]) . '%');
                }
            }

            if($request->byCode == '' && $request->byName == ''){
                $query = Material::all();
            }
        });

        return $query;
    }

    public function filterMaterialsPayment(Request $request ,$query){
        $items = Cart::session(Auth::user()->getId())->getContent()->count();
        $query = Material::where(function($query) use ($request, $items){
            if ($request->byName) {
                if($items > 0){
                    $query->where('for_exchange', 'yes');
                }else{
                    $query->where('for_buy', 'yes');
                }

                $query->where('name', 'LIKE', "%$request->byName%")->orWhere('color', 'LIKE', "%$request->byName%")->orWhere('code', 'LIKE', "%$request->byName%");
            }

            if ($request->byName == '') {
                if($items > 0){
                    $query->where('for_exchange', 'yes');
                }else{
                    $query->where('for_buy', 'yes');
                }
            }
        });

        return $query;
    }
}
