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
    protected $dates = ['deleted_at'];

    public function stones()
    {
        return $this->hasMany('App\Stone', 'contour_id');
    }

    public function filterContours(Request $request ,$query){
        $query = StoneContour::where(function($query) use ($request){
            if ($request->byName) {
                $query->where('name', 'LIKE', "%$request->byName%");
            }

            if ($request->byName == '') {
                $query = StoneContour::all();
            }
        });

        return $query;
    }
}
