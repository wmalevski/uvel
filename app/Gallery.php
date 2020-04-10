<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'photo',
        'table',
        'product_id',
        'model_id',
        'stone_id'
    ];

    protected $table = 'galleries';

    public function product()
    {
        return $this->hasOne('App\Product', 'product_id', 'product_id');
    }

    public function productOther()
    {
        return $this->hasOne('App\ProductOther', 'product_other_id', 'product_other_id');
    }

    public function model()
    {
        return $this->hasOne('App\Models', 'model_id');
    }

    public function stone()
    {
        return $this->hasOne('App\Stones', 'stone_id');
    }

    public function custom_order()
    {
        return $this->hasOne('App\CustomOrder', 'custom_order_id');
    }

    
    public function destroyWithPath(Gallery $photo){
        unlink(public_path('uploads/'.$photo->table.'/').$photo->photo);
        $photo->delete();
    }
}
