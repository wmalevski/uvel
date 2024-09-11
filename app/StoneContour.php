<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class StoneContour extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    protected $table = 'stone_contours';
    protected $casts = ['deleted_at'];

    public function stones()
    {
        return $this->hasMany('App\Stone', 'contour_id');
    }

    public function filterContours($term){
        $stoneContours = self::where(function($query) use ($term){
            if ($term) {
                $query->where('name', 'LIKE', "%$term%");
            }
        })->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $results = $stoneContours->map(function ($contour) {
            return [
                'id' => $contour->id,
                'text' => $contour->name
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => ['more' => $stoneContours->hasMorePages()],
        ]);
    }
}
