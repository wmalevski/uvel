<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Response;
use Stone;

class StoneSize extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
    ];

    protected $table = 'stone_sizes';

    protected $dates = ['deleted_at'];

    public function create($request){

        $validator = Validator::make( $request, [
            'name' => 'required|unique:stone_sizes',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $size = new StoneSize($request);
        $size->save();

        return $size;
    }
}
