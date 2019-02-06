<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Auth;

class MaterialQuantity extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'material_id',
        'quantity',
        'store_id'
    ];

    public function scopeCurrentStore()
    {
        return $this->where('store_id', Auth::user()->getStore()->id)->get();
    }

    public function scopeCurStore($query)
    {
        return $query->where('store_id', Auth::user()->getStore()->id)->get();
    }
    
    public function store(){
        return $this->belongsTo('App\Store')->withTrashed();
    }

    public function material(){
        return $this->belongsTo('App\Material')->withTrashed();
    }

    public function travelling(){
        return $this->belongsTo('App\MaterialTravelling')->withTrashed();
    }

    public function products(){
        return $this->hasMany('App\Product')->withTrashed();
    }

    public function filterMaterials(Request $request ,$query){
        $query = MaterialQuantity::where(function($query) use ($request){
            if ($request->byName) {
                $query->with('Material')->whereHas('Material', function($q) use ($request){
                    $q->where('name', 'LIKE', "%$request->byName%")->orWhere('color', 'LIKE', "%$request->byName%")->orWhere('code', 'LIKE', "%$request->byName%");
                });
            }

            if ($request->byName == '') {
                $query = MaterialQuantity::all();
            }
        });

        return $query;
    }

    protected $table = 'materials_quantities';
    protected $dates = ['deleted_at'];
}
