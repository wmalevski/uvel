<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materials;

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
}
