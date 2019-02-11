<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Nomenclature extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $table = 'nomenclatures';

    public function stones()
    {
        return $this->hasMany('App\Stone');
    }

    public function filterNomenclatures(Request $request ,$query){
        $query = Nomenclature::where(function($query) use ($request){
            if ($request->byName) {
                $query->where('name', 'LIKE', "%$request->byName%");
            }

            if ($request->byName == '') {
                $query = Nomenclature::all();
            }
        });

        return $query;
    }
}
