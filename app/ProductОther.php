<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOther extends Model
{
    protected $fillable = [
        'name',
        'type_id',
        'price',
        'quantity',
        'barcode',
        'store_id'
    ];

    protected $table = 'products_others';

    public function type()
    {
        return $this->belongsTo('App\ProductOtherType')->withTrashed();
    }

    public function store()
    {
        return $this->belongsTo('App\Store')->withTrashed();
    }

    public function reviews() 
    {
        return $this->hasMany('App\Review', 'product_others_id');
    }

    public function wishLists() 
    {
        return $this->hasMany('App\WishList');
    }
    
    public function getSimilarProductAvgRating($product) {
        $productTotalRating = 0;
        if(count($product->reviews)){
            foreach($product->reviews as $review) {
                $productTotalRating = $productTotalRating + $review->rating;
            }
            return $productAvgRating = $productTotalRating/count($product->reviews);
        }
    }

    public function filterProducts($request ,$query){
        if ($request->priceFrom && $request->priceTo) {
            $query = $query->whereBetween('price', [$request->priceFrom, $request->priceTo]);
        } else if($request->priceFrom){
            $query = $query->where('price', '>=', $request->priceFrom);
        } else if($request->priceTo){
            $query = $query->where('price', '<=', $request->priceTo);
        }

        if ($request->byStore) {
            $query = $query->whereIn('store_id', $request->byStore);
        }

        if ($request->byType) {
            $query = $query->whereIn('type_id', $request->byType);
        }

        return $query;
    }

    public function getProductOtherAvgRating($product_other) {
        $productOtherTotalRating = 0;
        if(count($product_other->reviews)){
            foreach($product_other->reviews as $review) {
                $productOtherTotalRating = $productOtherTotalRating + $review->rating;
            }
            return $productOtherAvgRating = $productOtherTotalRating/count($product_other->reviews);
        }
    }

    public function listProductOtherAvgRatingStars($product_other) {
        for($i = 1; $i <= 5; $i++){
            if($this->getProductOtherAvgRating($product_other) >= $i){
                echo '<i class="spr-icon spr-icon-star" style=""></i>';
            }elseif($this->getProductOtherAvgRating($product_other) < $i){
                echo'<i class="spr-icon spr-icon-star-empty" style=""></i>';
            }   																		
        }
    }
}
