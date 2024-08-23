<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

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

    public function filterRepairTypes(Request $request ,$query){
        $query = RepairType::where(function($query) use ($request){
            if ($request->byName) {
                $query->where('name','LIKE','%'.$request->byName.'%');
            }

            if( $request->byName == ''){
                $query = RepairType::all();
            }
        });

        return $query;
    }

    protected $casts = ['deleted_at'];

    protected $table = 'repair_types';
}
