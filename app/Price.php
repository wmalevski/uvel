<?php

namespace App;

use App\Material;
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
    protected $casts = ['deleted_at'];

    public function scopeMaterialPrices($query, $value)
    {
        return $query->where('material_id', $value)->get();
    }

    public function material()
    {
        return $this->belongsTo('App\Material');
    }

    public function filterMaterials(Request $request ,$query){
        $search = $request->search;
        $query = Material::where(function($query) use ($request) {
            $search = $request->search;

            if ($search) {
                $searchParts = explode("-", $search);
                $nameCount = count($searchParts);

                $query->whereHas('parent', function ($q) use ($searchParts) {
                    $q->where('name', 'LIKE', '%' . trim($searchParts[0]) . '%');
                });

                switch ($nameCount) {
                    case 1:
                        $query->orWhere('color', 'LIKE', '%' . trim($searchParts[0]) . '%')
                              ->orWhere('code', 'LIKE', '%' . trim($searchParts[0]) . '%');
                        break;
                    case 2:
                        $query->where('color', 'LIKE', '%' . trim($searchParts[1]) . '%');
                        break;
                    case 3:
                        $query->where('code', 'LIKE', '%' . trim($searchParts[2]) . '%');
                        break;
                }
            }
        });


        return $query;
    }
}
