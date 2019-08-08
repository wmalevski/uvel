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
            if($request->byName){
                if (trim($request->byName) == '-') {
                    $query = Material::all();
                } else {
                    $request->byName = explode("-", $request->byName);
                    $query->with('Material')->whereHas('Material', function($q) use ($request){
                        $q->where('name', 'LIKE', '%' . trim($request->byName[0]) . '%');
                        $name = count($request->byName);
                        switch ($name) {
                            case 1:
                                $q->orWhere('color', 'LIKE', '%' . trim($request->byName[0]) . '%')->orWhere('code', 'LIKE', '%' . trim($request->byName[0]) . '%');
                                break;
                            case ($name > 1):
                                $q->where('code', 'LIKE', '%' . trim($request->byName[1]) . '%');
                                break;
                            case ($name > 2):
                                $q->where('color', 'LIKE', '%' . trim($request->byName[2]) . '%');
                        }
                    });
                }
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
