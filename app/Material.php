<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'color',
        'carat',
        'parent'
    ];

    protected $table = 'materials';
    protected $dates = ['deleted_at'];

    public function parent(){
        return $this->belongsTo('App\MaterialType');
    }
}
