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

    public function search(Request $request)
    {
        if($request->search != ''){
            $results = MaterialQuantity::with('Material')->whereHas('Material', function($q) use ($request){
                $q->where('name', 'LIKE', "%$request->search%");
            })->get();

        }else{
            $results = MaterialQuantity::take(10)->get();
        }

        $pass_materials = array();

        foreach($results as $material){
            $pass_materials[] = [
                'value' => $material->id,
                'label' => $material->material->parent->name.' - '.$material->material->color.' - '.$material->material->carat,
                'data-carat' => $material->material->carat,
                'data-pricebuy' => $material->material->pricesBuy->first()->price
            ];
        }

        return $pass_materials;
    }

    protected $table = 'materials_quantities';
    protected $dates = ['deleted_at'];
}
