<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\DailyReport;
use App\Payment;
use App\Expense;
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
        // $dailyReports = DailyReport::whereDate('created_at', Carbon::today())->get();
        $dailyReports = DailyReport::all();
        
        return view('admin.daily_reports.index', compact('dailyReports'));
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
            ['method', '=', 'cash'],
            ['store_id', '=', Auth::user()->getStore()]
        ])->whereDate('created_at', Carbon::today())->sum('given');

        $expenses = Expense::where([
            ['store_id', '=', Auth::user()->getStore()]
        ])->whereDate('created_at', Carbon::today())->sum('given');

        $report = new DailyReport();
        $report->safe_amount = $request->safe_amount;
        $report->calculated_price = $allSold;
        $report->store_id = Auth::user()->getStore();
        $report->user_id = Auth::user()->getId();
        $report->save();

        if($allSold < ($request->safe_amount - $expenses)){
            return Response::json(['errors' => ['using' => ['Въведената сума не съвпата с тази в системата! Моля опитайте пак или се свържете с администратор!']]], 401);
        }else if($allSold == ($request->save_amount - $expenses)){
            return Response::json(array('success' => 'Успешно направихте дневен отчет!'));
        }else{
            return Response::json(['errors' => ['using' => ['Въведената сума не съвпата с тази в системата! Моля опитайте пак или се свържете с администратор!']]], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DailyReport  $dailyReport
     * @return \Illuminate\Http\Response
     */
    public function show(DailyReport $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DailyReport  $dailyReport
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyReport $report)
    {
        return \View::make('admin/daily_reports/edit',array('report'=>$report));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DailyReport  $dailyReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyReport $report)
    {
        $validator = Validator::make( $request->all(), [
            'safe_amount' => 'required',
            'calculated_price' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $report->safe_amount = $request->safe_amount;
        $report->calculated_price = $request->calculated_price;
        $report->save();

        return Response::json(array('ID' => $jewel->id, 'table' => View::make('admin/daily_reports/table',array('report'=>$report))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DailyReport  $dailyReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyReport $report)
    {
        if($report){
            
            $report->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
