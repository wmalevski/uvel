<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MaterialType extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
    ];

    protected $table = 'materials_types';
    protected $dates = ['deleted_at'];

    public function materials(){
        return $this->hasMany('App\Material', 'parent_id')->withTrashed();
    }

    public function defaultMaterial(){
        return $this->hasOne('App\Material', 'parent_id')->where('default', 'yes');
    }

    public function secondDefaultPrice(){
        $default_material = $this->defaultMaterial()->first();
        $default_price = $default_material->pricesBuy()->first()['price'];
        $second_default_price = 0;

        $check_second_price = Price::where([
            ['material_id', '=', $default_material->id],
            ['type', '=', 'buy'],
            ['price', '<>', $default_price],
            ['price', '<', $default_price]
        ])->orderBy(DB::raw('ABS(price - '.$default_price.')'), 'desc')->first();

        if($check_second_price){
            $second_default_price = $check_second_price->price;
        }

        return $second_default_price;
    }

    public function filterMaterialsPayment(Request $request ,$query){
        $query = MaterialType::where(function($query) use ($request){
            if($request->byName){
                $query->where('name', 'LIKE', '%' . $request->byName . '%');
            }

            if($request->byName == ''){
                $query = MaterialType::all();
            }
        });

        return $query;
    }

}
