<?php

namespace App;

use App\StoneSize;
use App\StoneStyle;
use App\StoneContour;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stone extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nomenclature_id',
        'type',
        'weight',
        'carat',
        'size_id',
        'style_id',
        'contour_id',
        'amount',
        'price',
        'store_id'
    ];

    protected $table = 'stones';
    protected $dates = ['deleted_at'];

    public function scopeActive()
    {
        return $this->where('amount', '>', 0)->get();
    }

    public function size()
    {
        return $this->belongsTo('App\StoneSize');
    }

    public function style()
    {
        return $this->belongsTo('App\StoneStyle');
    }

    public function contour()
    {
        return $this->belongsTo('App\StoneContour');
    }

    public function modelStones()
    {
        return $this->hasMany('App\ModelStone');
    }

    public function productStones()
    {
        return $this->hasMany('App\ProductStone');
    }

    public function store()
    {
        return $this->belongsTo('App\Store');
    }

    public function scopeCurrentStore()
    {
        return $this->where('store_id', Auth::user()->getStore()->id)->get();
    }

    public function photos()
    {
        return $this->hasMany('App\Gallery');
    }

    public function nomenclature()
    {
        return $this->belongsTo('App\Nomenclature');
    }

    public function filterStones(Request $request ,$query){
        $query = Stone::where(function($query) use ($request){
            if ($request->byName) {
                if (trim($request->byName) == '-') {
                    $query = Stone::all();
                } else {
                    $request->byName = explode("-", $request->byName);

                    $query->whereHas('Nomenclature', function ($q) use ($request) {
                        $q->where('name', 'LIKE', '%' . trim($request->byName[0]) . '%')->orWhere('weight', 'LIKE', '%' . trim($request->byName[0]) . '%');
                    });

                    if (count($request->byName) == 1) {
                        $query->orWhereHas('Contour', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . trim($request->byName[0]) . '%');
                        })->orWhereHas('Size', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . trim($request->byName[0]) . '%');
                        });
                    }

                    if (count($request->byName) > 1) {
                        $query->whereHas('Contour', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . trim($request->byName[1]) . '%');
                        });
                    }

                    if (count($request->byName) > 2) {
                        $query->whereHas('Size', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . trim($request->byName[2]) . '%');
                        });
                    }
                }
            }

            if($request->byName == ''){
                $query = Stone::all();
            }
        });

        return $query;
    }
}