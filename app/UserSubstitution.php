<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubstitution extends Model
{
    use SoftDeletes;

    protected $table = 'user_substitutions';
    protected $casts = ['date_from', 'date_to', 'deleted_at'];

    public function store()
    {
    	return $this->belongsTo('App\Store')->withTrashed();
    }

    public function user()
    {
    	return $this->belongsTo('App\User')->withTrashed();
    }

    public function scopeSubstitution($query)
    {
        return $query->where([
            ['user_id', '=', Auth::user()->id],
            ['date_to', '>=', date("Y-m-d")]
        ])->first();
    }
}
