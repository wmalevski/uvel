<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $table = 'reviews';

    protected $fillable = [
        'title',
        'content',
        'rating',
        'user_id',
        'product_id',
        'model_id',
        'product_others_id'
    ];

    protected $dates = ['deleted_at'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function product() {
        return $this->belongsTo('App\Product');
    }

    public function model() {
        return $this->belongsTo('App\Model');
    }

    public function productOther() {
        return $this->belongsTo('App\ProductOther');
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

    public function listSimilarProductAvgRatingStars($product) {
        for($i = 1; $i <= 5; $i++){
            if($this->getSimilarProductAvgRating($product) >= $i){
                echo '<i class="spr-icon spr-icon-star" style=""></i>';
            }elseif($product->getSimilarProductAvgRating($product) < $i){
                echo'<i class="spr-icon spr-icon-star-empty" style=""></i>';
            }   																		
        }
    }
}
