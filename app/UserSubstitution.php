<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubstitution extends Model
{
    use SoftDeletes;

    protected $table = 'user_substitutions';
    protected $dates = ['date_from', 'date_to', 'deleted_at'];

    public function store()
    {
    	return $this->belongsTo('App\Store');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
