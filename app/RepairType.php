<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    protected $dates = ['deleted_at'];

    protected $table = 'repair_types';
}
