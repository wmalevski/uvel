<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repair extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'type_id',
        'repair_description',
        'date_recieved',
        'date_returned',
        'code',
        'barcode',
        'weight',
        'weight_after',
        'price',
        'price_after',
        'material_id',
        'status'
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'repairs';

    public function type()
    {
        return $this->belongsTo('App\RepairType');
    }

    public function material()
    {
        return $this->belongsTo('App\Materials');
    }
}
