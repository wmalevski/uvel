<?php

namespace App\Http\Controllers;

use App\Dashboard;
use App\Usersubstitutions;
use App\DiscountCode;
use App\Currency;
use Illuminate\Http\Request;
use Auth;
use Cart;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = DiscountCode::all();
        $currencies = Currency::all();
        $cartConditions = Cart::session(Auth::user()->getId())->getConditions();
        $subTotal = Cart::session(Auth::user()->getId())->getSubTotal();
        $cartConditions = Cart::session(Auth::user()->getId())->getConditions();
        $condition = Cart::getCondition('Discount');
        if($condition){
            $priceCon = $condition->getCalculatedValue($subTotal);
        } else{
            $priceCon = 0;
        }

        // $substitution = Usersubstitutions::where([
        //     ['user_id', '=', Auth::user()->id],
        //     ['date_to', '>=', date("Y-m-d")]
        // ])->first();

        // if($substitution){
        //     Auth::user()->store = $substitution->store_id;
        // }

        $items = [];
        
        Cart::session(Auth::user()->getId())->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        return \View::make('admin/selling/index', array('items' => $items, 'discounts' => $discounts, 'conditions' => $cartConditions, 'currencies' => $currencies, 'priceCon' => $priceCon));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
