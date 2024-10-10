<?php

namespace App;

use App\PublicGallery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Jewel extends Model{
	use SoftDeletes;

	protected $fillable = array('name');
	protected $table = 'jewels';
	protected $casts = array('deleted_at');

	public function products(){
		return $this->hasMany('App\Product');
	}

	public function productsOnline(){
		return $this->hasMany('App\Product')->where('status', 'available')->where('store_id', '!=', 1)->where('website_visible', 'yes');
	}

	public function models(){
		return $this->hasMany('App\Model');
	}

	public function filterJewels(Request $request ,$query){
		$query = Jewel::where(function($query) use ($request){
			if($request->byName){
				$query->where('name','LIKE','%'.$request->byName.'%');
			}

			if($request->byName==''){
				$query = Jewel::all();
			}
		});

		return $query;
	}

	public function galleries()
	{
	    return $this->hasMany(PublicGallery::class, 'jewel_id');
	}
}
