<?php

namespace App;

use App\MaterialQuantity;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'material_id',
        'price',
        'type'
    ];

    protected $table = 'prices';
    protected $dates = ['deleted_at'];

    public function scopeMaterialPrices($query, $value)
    {
        return $query->where('material_id', $value)->get();
    }

    public function filterMaterials(Request $request ,$query){
        $query = Material::where(function($query) use ($request){
            if ($request->byName) {
                $query->where('name', 'LIKE', "%$request->byName%")->orWhere('color', 'LIKE', "%$request->byName%")->orWhere('code', 'LIKE', "%$request->byName%");
            }

            if ($request->byName == '') {
                $query = Material::all();
            }
        });

        return $query;
    }
}
