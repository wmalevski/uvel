<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Store extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'location',
        'phone',
    ];

    protected $table = 'stores';
    protected $casts = ['deleted_at'];

    public function users()
    {
    	return $this->hasMany('App\User')->get();
    }

    public function materials()
    {
        return $this->hasMany('App\MaterialQuantity');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function productsOnline()
    {
        return $this->hasMany('App\Product')->where('status', 'available')->where('store_id', '!=', 1)->where('website_visible', 'yes');
    }

    public function productsOther()
    {
        return $this->hasMany('App\ProductOther');
    }


    public function stones()
    {
    	return $this->hasMany('App\Stone');
    }

    public function filterStores(Request $request ,$query)
    {
        $query = Store::where(function ($query) use ($request) {
            if ($request->byName) {
                if (trim($request->byName) == '-') {
                    $query = Store::all();
                } else {
                    $request->byName = explode("-", $request->byName);
                    $query->where('name', 'LIKE', '%' . trim($request->byName[0]) . '%');

                    if (count($request->byName) == 1) {
                        $query->orWhere('location', 'LIKE', trim($request->byName[0]) . '%');
                    }

                    if (count($request->byName) > 1) {
                        $query->where('location', 'LIKE', trim($request->byName[1]) . '%');
                    }
                }
            }

            if ($request->byName == '') {
                $query = Store::all();
            }
        });

        return $query;
    }
}
