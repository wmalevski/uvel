<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductOtherType extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $table = 'products_others_types';

    public function productOther() {
        return $this->hasMany('App\ProductOther', 'type_id');
    }

    public function filterProducts($request ,$query){
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
