<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Repair extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'store_id',
        'customer_name',
        'customer_phone',
        'type_id',
        'repair_description',
        'date_recieved',
        'date_returned',
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
        return $this->belongsTo('App\RepairType')->withTrashed();
    }

    public function material()
    {
        return $this->belongsTo('App\Material')->withTrashed();
    }

    public function filterRepairs(Request $request ,$query){
        $query = Repair::where(function($query) use ($request){
            if ($request->byBarcode) {
                $query->where('barcode','LIKE','%'.$request->byBarcode.'%');
            }

            if ($request->byCode) {
                $query->where('id','LIKE','%'.$request->byCode.'%');
            }

            if ($request->byName) {
                $query->where('customer_name','LIKE','%'.$request->byName.'%');
            }

            if ($request->byPhone) {
                $query->where('customer_phone','LIKE','%'.$request->byPhone.'%');
            }

            if( $request->byName == '' && $request->byPhone == '' && $request->byBarcode == '' && $request->byCode == ''){
                $query = Repair::all();
            }
        });

        return $query;
    }
}
