<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomOrder extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'city',
        'phone',
        'email',
        'content',
        'status'
    ];

    protected $table = 'custom_orders';
    protected $dates = ['deleted_at'];

    public function photos()
    {
        return $this->hasMany('App\Gallery');
    }
}
