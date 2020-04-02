<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOtherType extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $table = 'products_others_types';

    public function productOther() {
        return $this->hasMany('App\ProductOther', 'type_id');
    }

    public static function filterProducts($request){
        $query = ProductOtherType::where(function($query) use ($request){
            if ($request->byName) {
                $query->where('name','LIKE','%'.$request->byName.'%');
            }

            if($request->byName == ''){
                $query = ProductOtherType::all();
            }

        });

        return $query;
    }
}
