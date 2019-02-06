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
    protected $dates = ['deleted_at'];

    public function stones()
    {
        return $this->hasMany('App\Stone', 'style_id');
    }

    public function filterStyles(Request $request ,$query){
        $query = StoneStyle::where(function($query) use ($request){
            if ($request->byName) {
                $query->where('name', 'LIKE', "%$request->byName%");
            }

            if ($request->byName == '') {
                $query = StoneStyle::all();
            }
        });

        return $query;
    }
}
