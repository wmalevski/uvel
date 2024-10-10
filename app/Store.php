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

    public function filterStores(Request $request)
    {
        $search = $request->search;
        $params = $request->all();

        // There are specific scenarios where header named 'search' is not present in the request so we have to overwrite it
        if (is_null($search)) {
            $search = reset($params);
        }
        // There are specific scenarios where header named 'search' is not present in the request so  we have overwrite it
        if (is_null($search)) {
            foreach($request->all() as $k => $v) {
                $search = $request->input($k);
                break;
            }
        }

        $stores = Store::where(function ($query) use ($search) {
            $query
                ->orWhere('name', 'like', '%' .$search. '%')
                ->orWhere('location', 'like', '%' .$search. '%');
        })
            ->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $results = $stores->map(function ($store) {
            return [
                'id' => $store->id,
                'text' => $store->name.' - '.$store->location
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => ['more' => $stores->hasMorePages()],
        ]);
    }
}
