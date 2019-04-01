<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class MaterialType extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
    ];

    protected $table = 'materials_types';
    protected $dates = ['deleted_at'];

    public function materials(){
        return $this->hasMany('App\Material', 'parent_id')->withTrashed();
    }

    public function defaultMaterial(){
        return $this->hasOne('App\Material', 'parent_id')->where('default', 'yes');
    }

    public function filterMaterialsPayment(Request $request ,$query){
        $query = MaterialType::where(function($query) use ($request){
            if($request->byName){
                $query->where('name', 'LIKE', '%' . $request->byName . '%');
            }

            if($request->byName == ''){
                $query = MaterialType::all();
            }
        });

        return $query;
    }

}
