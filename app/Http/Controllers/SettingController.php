<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Material;
use App\Currency;
use DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = Material::groupBy('name')->get();
        return \View::make('admin/settings/index', array('materials' => $materials));
    }

    public function stockPrices()
    {
        $materials = Material::groupBy('name')->get();
        return \View::make('admin/settings/stock', array('materials' => $materials));
    }

    public function updatePrices(Request $request)
    {
        foreach($request->mat as $mat => $key){
            $validator = Validator::make( $request->all(), [
                'stock_price.*' => 'required|numeric|between:0.1,10000'
            ]);

            if ($validator->fails()) {
                return Redirect::back();
            }

            $material = Material::find($key);
            $material->stock_price = $request->stock_price[$mat];
            $material->save();
        }

        return Redirect::back();
    }

    public function currencies()
    {
        $currencies = Currency::all();
        return \View::make('admin/settings/currencies', array('currencies' => $currencies));
    }
}
