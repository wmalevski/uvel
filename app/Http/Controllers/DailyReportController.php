<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\DailyReport;
use App\Payment;
use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Material;
use App\MaterialQuantity;
use App\Jewel;
use App\Currency;

class DailyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dailyReports = DailyReport::whereDate('created_at', Carbon::today())->get();
        
        return view('admin.daily_reports.index', compact('dailyReports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jewels = Jewel::all();
        $materials = Material::all();
        $currencies = Currency::where('default', 'no')->get();

        $dailyReports = DailyReport::whereDate('created_at', Carbon::today())->get();

        return view('admin.daily_reports.create', compact('dailyReports', 'materials', 'jewels', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    public function moneyReport(Request $request){
        $dailyReport = new DailyReport();
        $dailyReport = $dailyReport->moneyReport($request);

        return $dailyReport;
    }

    public function jewelReport(Request $request){
        $dailyReport = new DailyReport();
        $dailyReport = $dailyReport->jewelReport($request);

        return $dailyReport;
    }

    public function materialReport(Request $request){
        $dailyReport = new DailyReport();
        $dailyReport = $dailyReport->materialReport($request);

        return $dailyReport;
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
