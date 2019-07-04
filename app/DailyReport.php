<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Payment;
use App\Expanse;
use App\Currency;
use App\DailyReportBanknote;
use App\DailyReportJewel;
use App\DailyReportMaterial;
use Response;
use Redirect;
use Auth;

class DailyReport extends Model
{
    public function store(){
        return $this->belongsTo('App\Store')->withTrashed();
    }

    public function user(){
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function report_jewels(){
        return $this->hasMany('App\DailyReportJewel', 'report_id');
    }

    public function report_materials(){
        return $this->hasMany('App\DailyReportMaterial' , 'report_id');
    }

    public function report_banknotes(){
        return $this->hasMany('App\DailyReportBanknote' , 'report_id');
    }

    public function moneyReport(Request $request){
        //Getting all banknote fields and summing them
        $sum = 0;
        foreach($request->banknote as $key => $banknote) {
            $quantity = $request->quantity[$key] ? $request->quantity[$key] : 0;
            $calculate = $banknote * $quantity;
            $sum += $calculate;
        }

        $defaultCurrency = Currency::where('default', 'yes')->first();
        
        $allSold = Payment::where([
            ['method', '=', 'cash'],
            ['receipt', '=', 'yes'],
            ['store_id', '=', Auth::user()->getStore()->id],
            ['currency_id', '=', $defaultCurrency->id]
        ])->whereDate('created_at', Carbon::today())->sum('given');

        $expenses = Expense::where([
            ['store_id', '=', Auth::user()->getStore()->id]
        ])->whereDate('created_at', Carbon::today())->sum('amount');

        $allSold = $allSold - $expenses;

        $todayReport = DailyReport::where([
            ['store_id', '=', Auth::user()->getStore()->id],
            ['status', '=', 'successful'],
            ['type', '=', 'money']
        ])->whereDate('created_at', Carbon::today())->get();

        $report = new DailyReport();
        $report->safe_money_amount = $allSold;
        $report->given_money_amount = $sum;
        $report->store_id = Auth::user()->getStore()->id;
        $report->user_id = Auth::user()->getId();
        
        if(count($todayReport)){
            $todayReport = 'true';
        }else{
            $todayReport = 'false';
        }
        
        if($allSold != $sum){
            $report->status = 'unsuccessful';
        }else{
            $report->status = 'successful';
        }

        if($todayReport == 'false'){
            $report->save();

            foreach($request->banknote as $key => $banknote) {
                $quantity = $request->quantity[$key] ? $request->quantity[$key] : 0;
                $calculate = $banknote * $request->quantity[$key];

                $report_banknote = new DailyReportBanknote();
                $report_banknote->banknote = $banknote;
                $report_banknote->quantity = $quantity;
                $report_banknote->report_id = $report->id;
                $report_banknote->save();
            }

            foreach($request->currency_id as $key => $currency){
                if($request->quantity[$key] != '' && $request->quantity[$key] > 0){
                    $check = Payment::where([
                        ['method', '=', 'cash'],
                        ['receipt', '=', 'yes'],
                        ['store_id', '=', Auth::user()->getStore()->id],
                        ['currency_id', '=', $currency]
                    ])->whereDate('created_at', Carbon::today())->sum('given');

                    if($check != $request->quantityp[$key]){
                        return Redirect::back()->withErrors(['not_matching.money' => trans('admin/reports.quantity_not_matching')], 'form_money');
                    }
                }
            }

            if($allSold == $sum){
                return Redirect::back()->with(['success.money' => trans('admin/reports.success')]);
            }else{
                return Redirect::back()->withErrors(['not_matching.money' => trans('admin/reports.quantity_not_matching')], 'form_money');
            }
        }else{
            return Redirect::back()->withErrors(['already_exists.money' => trans('admin/reports.already_exists')], 'form_money');
        }
    }

    public function jewelReport(Request $request){
        $todayReport = DailyReport::where([
            ['store_id', '=', Auth::user()->getStore()->id],
            ['status', '=', 'successful'],
            ['type', '=', 'jewels']
        ])->whereDate('created_at', Carbon::today())->get();

        if(count($todayReport)){
            $todayReport = 'true';
        }else{
            $todayReport = 'false';
        }

        $report = new DailyReport();
        $report->type = 'jewels';
        $report->store_id = Auth::user()->getStore()->id;
        $report->user_id = Auth::user()->getId();

        $total_given = 0;
        $total_check = 0;
        $errors = [];
        $flag_errors = false;
        if($todayReport == 'false'){
            foreach ($request->material_id as $key => $material) {
                $total_given += $request->quantity[$key];
                $quantity = $request->quantity[$key];
                $check = Product::where('material_id', $material)->where('status', 'available')->orWhere('status', 'travelling')->count();
                $total_check += $check;
                if (isset($request->quantity[$key])) {
                    if ($check == $quantity) {
                        $report->save();
                        $report_jewel = new DailyReportJewel();
                        $report_jewel->material_id = $material;
                        $report_jewel->quantity = $quantity;
                        $report_jewel->report_id = $report->id;
                        $report_jewel->save();
                    }
                }
                if ($check != $quantity) {
                    $flag_errors = true;
                }
            }

            if ($flag_errors) {
                $errors['not_matching_quantity.jewels'] = trans('admin/reports.quantity_not_matching');
                $report->save();
            }

            $allSold = UserPayment::where([
                ['status', 'done'],
                ['store_id', Auth::user()->getStore()->id]
            ])->whereDate('created_at', Carbon::today())->sum('price');

            if($request->fiscal_amount != $allSold){
                $errors['not_matching_fiscal.jewels'] = trans('admin/reports.fiscal_not_matching');
            }

            if ($total_check != $total_given || $request->fiscal_amount != $allSold) {
                $report->status = 'unsuccessful';
            } else {
                $report->status = 'successful';
            }

            $report->safe_jewels_amount = $total_check;
            $report->given_jewels_amount = $total_given;

            if ($request->fiscal_amount == '') $request->fiscal_amount = 0;
            $report->fiscal_amount = $request->fiscal_amount;

            $report->save();

            if($errors){
                return Redirect::back()->withErrors($errors, 'form_jewels');
            }

            return Redirect::back()->with(['success.jewels' => trans('admin/reports.success')]);
        }else{
            return Redirect::back()->withErrors(['already_exists.jewels' => trans('admin/reports.already_exists')], 'form_jewels');
        }
    }

    public function materialReport(Request $request){
        $todayReport = DailyReport::where([
            ['store_id', '=', Auth::user()->getStore()->id],
            ['status', '=', 'successful'],
            ['type', '=', 'materials']
        ])->whereDate('created_at', Carbon::today())->get();

        $report = new DailyReport();
        $report->type = 'materials';
        $report->store_id = Auth::user()->getStore()->id;
        $report->user_id = Auth::user()->getId();

        if (count($todayReport)) {
            $todayReport = 'true';
        } else {
            $todayReport = 'false';
        }

        $total_given = 0;
        $errors = [];
        $flag_errors = false;
        if ($todayReport == 'false') {
            foreach ($request->material_id as $key => $material) {
                $total_given += $request->quantity[$key];
                $quantity = $request->quantity[$key];
                $check = MaterialQuantity::where('material_id', $material)->first();
                if (!$quantity) {
                    $quantity = 0;
                }
                $report->save();
                $report_material = new DailyReportMaterial();
                $report_material->material_id = $material;
                $report_material->quantity = $quantity;
                $report_material->report_id = $report->id;
                $report_material->save();

                if ($check->quantity != $quantity) {
                    $flag_errors = true;
                }
            }

            if ($flag_errors) {
                $errors['not_matching.materials'] = trans('admin/reports.quantity_not_matching');
                $report->save();
            }

            if ($errors) {
                $report->status = 'unsuccessful';
            } else {
                $report->status = 'successful';
            }

            $report->safe_materials_amount = $check->quantity;
            $report->given_materials_amount = $total_given;

            $report->save();

            if ($errors) {
                return Redirect::back()->withErrors($errors, 'form_materials');
            }

            return Redirect::back()->with(['success.materials' => trans('admin/reports.success')]);
        } else {
            return Redirect::back()->withErrors(['already_exists.jewels' => trans('admin/reports.already_exists')], 'form_materials');
        }
    }
}
