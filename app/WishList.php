<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model{
	protected $table = 'wish_lists';

	protected $dates = array('deleted_at');

	protected $fillable = array(
		'user_id',
		'product_id',
		'model_id',
		'product_others_id'
	);

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function product(){
		return $this->belongsTo('App\Product');
	}

	public function model(){
		return $this->belongsTo('App\Model');
	}

	public function productOther(){
		return $this->belongsTo('App\ProductOther', 'product_others_id');
	}

	public function checkWishListItemType($wishListItem){
		if($wishListItem->product_id){
			return array(
				'item'=>$wishListItem->product,
				'url'=>route('single_product', array('product'=>$wishListItem->product->id)
			));
		}
		elseif($wishListItem->model_id){
			return array(
				'item'=>$wishListItem->model,
				'url'=>route('single_model', array('model'=>$wishListItem->model->id)
			));
		}
		elseif($wishListItem->product_others_id){
			return array(
				'item'=>$wishListItem->productOther,
				'url'=>route('single_product_other', array('product'=>$wishListItem->productOther->id)
			));
		}
	}
}