<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
