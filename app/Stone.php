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
    protected $casts = ['deleted_at'];

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

    public function filterStones(Request $request){
        $search = $request->search ?? $request->byName;
        $query = Stone::where(function($query) use ($request, $search){
            if ($search) {
                if (trim($search) == '-') {
                    $query = Stone::all();
                } else {
                    $search = explode("-", $search);
                    $query->whereHas('Nomenclature', function ($q) use ($request, $search) {
                        $q->where('name', 'LIKE', '%' . trim($search[0]) . '%')->orWhere('weight', 'LIKE', '%' . trim($search[0]) . '%');
                    });

                    if (count($search) == 1) {
                        $query->orWhereHas('Contour', function ($q) use ($request, $search) {
                            $q->where('name', 'like', '%' . trim($search[0]) . '%');
                        })->orWhereHas('Size', function ($q) use ($request, $search) {
                            $q->where('name', 'like', '%' . trim($search[0]) . '%');
                        });
                    }

                    if (count($search) > 1) {
                        $query->whereHas('Contour', function ($q) use ($request, $search) {
                            $q->where('name', 'like', '%' . trim($search[1]) . '%');
                        });
                    }

                    if (count($search) > 2) {
                        $query->whereHas('Size', function ($q) use ($request, $search) {
                            $q->where('name', 'like', '%' . trim($search[2]) . '%');
                        });
                    }
                }
            }

            if($search == ''){
                $query = Stone::all();
            }
        });

        return $query;
    }

    public function searchQuery($term){
        $stones = self::with(['contour', 'nomenclature', 'size'])
            ->where(function($query) use ($term) {
                $query->whereHas('Nomenclature', function ($q) use ($term) {
                    $q->where('name', 'LIKE', '%' . $term . '%')
                        ->orWhere('weight', 'LIKE', '%' . $term . '%');
                })->orWhereHas('Contour', function ($q) use ($term) {
                    $q->where('name', 'like', '%' . trim($term) . '%');
                })->orWhereHas('Size', function ($q) use ($term) {
                    $q->where('name', 'like', '%' . trim($term) . '%');
                });
            })
            ->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $results = $stones->map(function ($stone) {
            return [
                'id' => $stone->id,
                'text' => $stone->nomenclature->name.' - '.$stone->contour->name.' - '.$stone->size->name.' - '.$stone->weight.' гр',
                'attributes' => [
                    'data-price' => $stone->price,
                    'data-type' => $stone->type
                ],
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => ['more' => $stones->hasMorePages()],
        ]);
    }
}
