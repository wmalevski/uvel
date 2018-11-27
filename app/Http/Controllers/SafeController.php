<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SafeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        return \View::make('admin/safe/index', array());
    }
}
