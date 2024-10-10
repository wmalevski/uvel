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
        $search = $request->search; // Using single 'search' input

        // $query = Material::where(function($query) use ($request){
        //     if($request->byCode){
        //         $query = $query->whereIn('code', [$request->byCode]);
        //     }

        //     if($request->byName || $request->search){
        //         if (trim($request->byName) == '-') {
        //             $query = Material::all();
        //         } else {
        //             $request->byName = explode("-", $request->byName);

        //             $query->whereHas('parent', function ($q) use ($request) {
        //                 $q->where('name', 'LIKE', '%' . trim($request->byName[0]) . '%');
        //             });

        //             $name = count($request->byName);
                    
        //             switch ($name) {
        //                 case 1:
        //                     $query->orWhere('color', 'LIKE', '%' . trim($request->byName[0]) . '%')->orWhere('code', 'LIKE', '%' . trim($request->byName[0]) . '%');
        //                     break;
        //                 case ($name > 1):
        //                     $query->where('color', 'LIKE', '%' . trim($request->byName[1]) . '%');
        //                     break;
        //                 case ($name > 2):
        //                     $query->where('code', 'LIKE', '%' . trim($request->byName[2]) . '%');
        //             }
        //         }
        //     }

        //     if ($request->byName == '') {
        //         $query = Material::all();
        //     }
        // });

        $query = Material::where(function($query) use ($request) {
            $search = $request->search; // Using single 'search' input

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
