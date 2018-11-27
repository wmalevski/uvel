<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\DailyReport;
use App\Payment;
use Illuminate\Http\Request;
use Response;

class DailyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $allSold = Payment::where([
            ['method', '=', 'cash']
        ])->whereDate('created_at', Carbon::today())->sum('given');

        //$todayReport = DailyReport::whereDate('created_at', Carbon::today())->get();

        $report = new DailyReport();
        $report->safe_amount = $request->safe_amount;
        $report->calculated_price = $allSold;
        $report->store_id = Auth::user()->getStore();
        $report->user_id = Auth::user()->getId();
        $report->save();

        return Response::json(array('success' => 'Успешно направихте дневен отчет!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DailyReport  $dailyReport
     * @return \Illuminate\Http\Response
     */
    public function show(DailyReport $dailyReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DailyReport  $dailyReport
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyReport $dailyReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DailyReport  $dailyReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyReport $dailyReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DailyReport  $dailyReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyReport $dailyReport)
    {
        //
    }
}
