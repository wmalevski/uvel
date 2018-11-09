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
        return $this->hasMany('App\Review');
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
}
