<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerMaterial extends Model{
    protected $table = 'partner_materials';

    public function material(){
        return $this->belongsTo('App\MaterialQuantity');
    }
}
