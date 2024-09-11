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

    public function filterNomenclatures($term){
        $nomenclatures = self::where(function($query) use ($term){
            if ($term) {
                $query->where('name', 'LIKE', "%$term%");
            }
        })->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $results = $nomenclatures->map(function ($n) {
            return [
                'id' => $n->id,
                'text' => $n->name
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => ['more' => $nomenclatures->hasMorePages()],
        ]);
    }
}
