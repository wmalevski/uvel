<?php

namespace App\Http\Controllers\Store;

class StorePricesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \View::make('store.pages.prices');
    }
}
