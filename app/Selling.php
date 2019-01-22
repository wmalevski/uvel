<?php

namespace App;

use Cart;
use Auth;
use App\Partner;
use Illuminate\Database\Eloquent\Model;

class Selling extends Model
{
    public function repair(){
        return $this->belongsTo('App\Repair');
    }

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function product_other(){
        return $this->belongsTo('App\ProductOther');
    }

    public function cartMaterialsInfo(){
        $items = [];
        $products = [];
        
        Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items) {
            $items[] = $item->id;
        });

        $products = Product::whereIn('barcode', $items)->get();
        $workmanship = $products->sum('workmanship');

        $cartConditions = Cart::getConditions();
        $partner_info = [];

        foreach($cartConditions as $condition) {
            $attributes = $condition->getAttributes();

            if($attributes['partner'] == 'true'){
                if($attributes['partner_id'] && $attributes['partner_id'] != ''){
                    $user = User::find($attributes['partner_id']);
                    $partner = Partner::where('user_id', $user->id)->first();

                    $partner_info = [
                        'name' => $user->name,
                        'money' => $partner->money
                    ];
                }
            }
        }

        $materials = [];
        foreach($products as $key => $product){
            $material = $product->material->material;

            if(array_key_exists($material->id, $materials)) {
                $materials[$material->id]['weight'] = $materials[$material->id]['weight']+$product->weight;
            } else {  
                $partner_material = '';
                $partner_material_weight = '';

                foreach($partner->materials as $p_material){
                    if($p_material->material_id == $material->id && $p_material->quantity > 0){
                        $partner_material = $p_material->id;
                        $partner_material_weight = $p_material->quantity;
                    }
                }    

                $materials[$material->id] = [
                    'material_id' => $material->id,
                    'name' => $material->parent->name,
                    'carat' => $material->carat,
                    'code' => $material->code,
                    'weight' => $product->weight,
                    'partner_material' => $partner_material,
                    'partner_material_weight' => $partner_material_weight 
                ];
            }   
        }

        return array('materials' =>  json_encode($materials, JSON_UNESCAPED_SLASHES), 'workmanship' => $workmanship, 'partner' => $partner_info);
    }
}
