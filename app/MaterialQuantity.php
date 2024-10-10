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
        $term = $request->get('byName');
        $query = MaterialQuantity::where(function($query) use ($term){
            if($term){
                if (trim($term) == '-') {
                    $query = Material::all();
                } else {
                    $term = explode("-", $term);
                    $query->with('Material')->whereHas('Material', function($q) use ($term){
                        $q->where('name', 'LIKE', '%' . trim($term[0]) . '%');
                        $name = count($term);
                        switch ($name) {
                            case 1:
                                $q->orWhere('color', 'LIKE', '%' . trim($term[0]) . '%')->orWhere('code', 'LIKE', '%' . trim($term[0]) . '%');
                                break;
                            case ($name > 1):
                                $q->where('code', 'LIKE', '%' . trim($term[1]) . '%');
                                break;
                            case ($name > 2):
                                $q->where('color', 'LIKE', '%' . trim($term[2]) . '%');
                        }
                    });
                }
            }

            if ($term == '') {
                $query = MaterialQuantity::all();
            }
        });

        return $query;
    }

    protected $table = 'materials_quantities';
    protected $casts = ['deleted_at'];
}
