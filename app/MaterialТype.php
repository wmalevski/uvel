<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialType extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
    ];

    protected $table = 'materials_types';
    protected $dates = ['deleted_at'];

    public function materials(){
        return $this->hasMany('App\Material', 'parent_id')->withTrashed();
    }

}
