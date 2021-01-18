<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomeType extends Model{
	protected $fillable = array('name');

	protected $table = 'income_types';
}