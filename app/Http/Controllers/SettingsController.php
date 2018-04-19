<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Materials;
use App\Currencies;
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

    public function stockPrices()
    {
        $materials = Materials::groupBy('name')->get();
        return \View::make('admin/settings/stock', array('materials' => $materials));
    }

    public function updatePrices(Request $request)
    {
        foreach($request->mat as $mat => $key){
            $material = Materials::find($key);
            $material->stock_price = $request->stock_price[$mat];
            $material->save();
        }

        return Redirect::back();
    }

    public function currencies()
    {
        $currencies = Currencies::all();
        return \View::make('admin/settings/currencies', array('currencies' => $currencies));
    }
}
