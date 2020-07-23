<?php

namespace App\Http\Controllers;

use App\ExpenseType;
use App\MaterialTravelling;
use App\Product;
use App\ProductTravelling;
use App\Selling;
use Auth;
use Carbon\Carbon;
use App\DailyReport;
use App\Payment;
use App\Expense;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Response;
use App\Material;
use App\MaterialType;
use App\Jewel;
use App\Currency;
use App\Store;

class DailyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dailyReport = DailyReport::whereDate('created_at', Carbon::today());
        
        if(Auth::user()->role != 'admin') $dailyReport->where('store_id', Auth::user()->getStore()->id);

        $dailyReports = $dailyReport->get();
        
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
        $materialTypes = MaterialType::all();
        $currencies = Currency::where('default', 'no')->get();
        $stores = Store::all();
        $user = Auth::user();
        $shUserAccessDailyMoneyReport = $user->shUserAccessDailyMoneyReport();
        $shUserChooseDailyMoneyReportStore = $user->shUserChooseDailyMoneyReportStore();
        $storesSelectValue = $user->store_id;
        $shUserAccessDailyMaterialReport = $user->shUserAccessDailyMaterialReport();

        $dailyReports = DailyReport::whereDate('created_at', Carbon::today())->get();

        return view('admin.daily_reports.create', compact(
            'dailyReports',
            'materials',
            'materialTypes', 
            'jewels', 
            'currencies',
            'stores',
            'shUserAccessDailyMoneyReport',
            'shUserChooseDailyMoneyReportStore',
            'storesSelectValue',
            'shUserAccessDailyMaterialReport'
            )
        );
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

    public function filterInquiryDate(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'dateStart' => 'required',
            'dateEnd' => 'required',
            'reportKey' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        if($request->reportKey == 'sellingreportsexport') {
            $payments = Payment::join('sellings', 'sellings.payment_id', '=', 'payments.id')->where('payments.store_id', $request->reportStoreId)->selectRaw('sellings.product_id')->selectRaw('payments.id')->selectRaw('payments.method')->selectRaw('payments.user_id')->get();
            $products = Product::all();
            $store = Store::find($request->reportStoreId)->first();
            $result = '';

            foreach($payments as $payment) {
                foreach($products as $product) {
                    $sale = new DateTime(Selling::where('product_id', $payment->product_id )->first()->created_at);
                    $saleDate = $sale->format('Y-m-d');

                    if($product->id == $payment->product_id && $saleDate >= $request->dateStart &&  $saleDate <= $request->dateEnd) {
                        $result .= View::make('admin.selling_reports.table_edit',array('store' => $store, 'payment' => $payment))->render();
                    }
                }
            }

            if(empty($result)) {
                $result = "<div class=\"alert alert-danger\">Няма продажби между $request->dateStart и $request->dateEnd!</div>";

                return Response::json(array('error' => $result));
            }

            return Response::json(array('table' => $result));

        }elseif($request->reportKey == 'mtravellingreports') {
            $materials_travellings = MaterialTravelling::all();
            $result = '';

            foreach($materials_travellings as $materials_travelling) {
                $materialTravellingDate = new DateTime($materials_travelling->dateReceived);
                $dateMaterialReceived = $materialTravellingDate->format('Y-m-d');

                if($dateMaterialReceived >= $request->dateStart &&  $dateMaterialReceived <= $request->dateEnd) {
                    $result .= View::make('admin.reports.mtravelling_reports.table',array('materials_travelling' => $materials_travelling))->render();
                }
            }

            if(empty($result)) {
                $result = "<div class=\"alert alert-danger\">Няма материали между $request->dateStart и $request->dateEnd!</div>";

                return Response::json(array('error' => $result));
            }

            return Response::json(array('table' => $result));

        }elseif($request->reportKey == 'productstravellingreports') {
            $products_travellings = ProductTravelling::all();
            $result = '';

            foreach($products_travellings as $products_travelling) {
                $productTravellingDate = new DateTime($products_travelling->date_received);
                $dateProductReceived = $productTravellingDate->format('Y-m-d');

                if($dateProductReceived >= $request->dateStart &&  $dateProductReceived <= $request->dateEnd) {
                    $result .= View::make('admin.reports.productstravelling_reports.table',array('products_travelling' => $products_travelling))->render();
                }
            }

            if(empty($result)) {
                $result = "<div class=\"alert alert-danger\">Няма продукти между $request->dateStart и $request->dateEnd!</div>";

                return Response::json(array('error' => $result));
            }

            return Response::json(array('table' => $result));

        }elseif($request->reportKey == 'expenses') {
            if(Auth::user()->role != 'admin') {
                $expenses = Expense::where('store_from_id', Auth::user()->getStore()->id)->orWhere('store_to_id', Auth::user()->getStore()->id)->get();
            } else {
                $expenses = Expense::all();
            }

            $result = '';

            foreach($expenses as $expense) {
                $expenseDate = new DateTime($expense->created_at);
                $dateExpenseCreatedAt = $expenseDate->format('Y-m-d');

                if($dateExpenseCreatedAt >= $request->dateStart &&  $dateExpenseCreatedAt <= $request->dateEnd) {
                    $result .= View::make('admin.expenses.table',array('expense' => $expense))->render();
                }
            }

            if(empty($result)) {
                $result = "<div class=\"alert alert-danger\">Няма разходи между $request->dateStart и $request->dateEnd!</div>";

                return Response::json(array('error' => $result));
            }

            return Response::json(array('table' => $result));
        }
    }
}
