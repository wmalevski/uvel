<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Materials;
use DB;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = Materials::groupBy('carat')->get();
        return \View::make('admin/settings/index', array('materials' => $materials));
    }

    public function updatePrices(Request $request){
        foreach($request->carat as $carat => $key){
            
            print_r($carat[$key]);

            DB::table('materials')
            ->where('carat', $carat)
            ->update(['stock_price' => $key]);
        }
        return Redirect::back();
    }
}
