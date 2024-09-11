<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class StoneStyle extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
    ];

    protected $table = 'stone_styles';
    protected $casts = ['deleted_at'];

    public function stones()
    {
        return $this->hasMany('App\Stone', 'style_id');
    }

    public function filterStyles($term) {
        $stoneStyles = self::where(function($query) use ($term){
            if ($term) {
                $query->where('name', 'LIKE', "%$term%");
            }
        })->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $results = $stoneStyles->map(function ($style) {
            return [
                'id' => $style->id,
                'text' => $style->name
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => ['more' => $stoneStyles->hasMorePages()],
        ]);
    }
}
