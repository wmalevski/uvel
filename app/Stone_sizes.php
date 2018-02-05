<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Response;

class Stone_sizes extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $table = 'stone_sizes';

    public function create($request){

        $validator = Validator::make( $request, [
            'name' => 'required|unique:stone_sizes',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $size = new Stone_sizes($request);
        $size->save();

        return $size;
    }
}
