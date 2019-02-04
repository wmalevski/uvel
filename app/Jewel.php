<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Jewel extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name'
    ];

    protected $table = 'jewels';
    protected $dates = ['deleted_at'];

    public function products() {
    	return $this->hasMany('App\Product');
    }

    public function productsOnline() {
    	return $this->hasMany('App\Product')->where('status', 'available');
    }

    public function models() {
    	return $this->hasMany('App\Model');
    }

    public function filterJewels(Request $request ,$query){
        $query = Jewel::where(function($query) use ($request){
            if ($request->byName) {
                $query->where('name','LIKE','%'.$request->byName.'%');
            }

            if( $request->byName == '' ) {
                $query = Jewel::all();
            }
        });

        return $query;
    }
}
