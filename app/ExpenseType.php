<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $table = 'expense_types';
}
