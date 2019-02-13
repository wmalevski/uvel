<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

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
        return $this->hasManyThrough('App\Product', 'App\MaterialQuantity', 'material_id', 'material_id');
    }

    public function productsOnline(){
        return $this->hasManyThrough('App\Product', 'App\MaterialQuantity', 'material_id', 'material_id')->where('status', 'available');
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
                $query->whereHas('parent', function($q) use ($request){
                    $q->where('name', 'LIKE', '%' . $request->byName . '%');
                })->orWhere('code','LIKE','%'.$request->byName.'%')->orWhere('color','LIKE','%'.$request->byName.'%');
            }

            if($request->byCode == '' && $request->byName == ''){
                $query = Material::all();
            }
        });

        return $query;
    }
}
