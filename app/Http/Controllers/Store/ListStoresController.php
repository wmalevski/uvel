<?php

namespace App\Http\Controllers\Store;
use App\Product;
use App\ProductOther;
use App\ProductOtherType;
use App\Store;
use App\Material;
use App\MaterialType;
use App\Jewel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;

class ListStoresController extends BaseController{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $stores = Store::where('id', '!=', 1)->get();

        foreach($stores as $k=>$store){
            if($store->productsOnline()->count()<1){
                unset($stores[$k]);
            }
        }

        $productothertypes = ProductOtherType::all();

        $materials = Material::groupBy('parent_id')->get();

        return \View::make('store.pages.stores.index', array('stores' => $stores, 'materials' => $materials, 'productothertypes' => $productothertypes));
    }
}
