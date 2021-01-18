<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model{
	protected $fillable = array(
		'type_id',
		'amount',
		'currency_id',
		'user_id',
		'store_id',
		'additional_info'
	);

	protected $table = 'income';

	public function type(){
		return $this->belongsTo('App\IncomeType');
	}

	public function currency(){
		return $this->belongsTo('App\Currency');
	}

	public function user(){
		return $this->belongsTo('App\User');
	}

}