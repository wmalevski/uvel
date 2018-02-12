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
        $materials = Materials::groupBy('name')->get();
        return \View::make('admin/settings/index', array('materials' => $materials));
    }

    public function updatePrices(Request $request){
        foreach($request->mat as $mat => $key){
            //dd($key);
            DB::table('materials')
            ->where('id', '=', $mat)
            ->update(['stock_price' => $request->stock_price[$key]]);
        }
        
        return Redirect::back();
    }
}
