<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ModelOrder extends Model
{
    //

    public function model()
    {
        return $this->belongsTo('App\Model');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function filterOrders(Request $request ,$query){
        $query = ModelOrder::where(function($query) use ($request){

            if ($request->byЕmail) {
                $query->with('User')->whereHas('User', function($q) use ($request){
                    $q->where('email', 'LIKE', "%$request->byЕmail%");
                });
            }

            if( $request->byName == '' && $request->byЕmail == ''){
                $query = ModelOrder::all();
            }
        });

        return $query;
    }
}
