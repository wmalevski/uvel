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

    protected $casts = ['deleted_at'];

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

    public function stones()
    {
        return $this->hasMany('App\Stone', 'size_id');
    }

    public function filterSizes($term){
        $stonesizes = self::where(function($query) use ($term){
            if ($term) {
                $query->where('name', 'LIKE', "%$term%");
            }
        })->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $results = $stonesizes->map(function ($size) {
            return [
                'id' => $size->id,
                'text' => $size->name
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => ['more' => $stonesizes->hasMorePages()],
        ]);
    }
}
