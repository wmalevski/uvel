<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class CustomOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'city',
        'phone',
        'email',
        'content',
        'status'
    ];

    protected $table = 'custom_orders';
    protected $dates = array('deadline','deleted_at');

    public function photos(){
        return $this->hasMany('App\Gallery');
    }

    public function filterOrders(Request $request ,$query){
        $query = CustomOrder::where(function($query) use ($request){

            if ($request->byEmail) {
                $query = $query->where('email','LIKE','%'.$request->byEmail.'%');
            }

            if( $request->byName == '' && $request->byEmail == ''){
                $query = CustomOrder::all();
            }
        });

        return $query;
    }
}
