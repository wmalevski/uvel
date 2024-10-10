<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class RepairType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
    ];

    public function repairs()
    {
        return $this->hasMany('App\Repair', 'type_id');
    }

    public function searchQuery($term){
        $repairTypes = self::where(function($query) use ($term){
            $query->where('name','LIKE','%'.$term.'%');
        })->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $results = $repairTypes->map(function ($rt) {
            return [
                'id' => $rt->id,
                'text' => $rt->name,
                'attributes' => [
                    'data-price' => $rt->price
                ],
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => ['more' => $repairTypes->hasMorePages()],
        ]);
    }

    protected $casts = ['deleted_at'];

    protected $table = 'repair_types';
}
