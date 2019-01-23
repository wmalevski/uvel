<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Payment;
use App\DailyReport;
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
        $allSold = Payment::where('method', 'cash')->sum('given');
        $todayReport = DailyReport::whereDate('created_at', Carbon::today())->get();
        
        if(count($todayReport)){
            $todayReport = 'true';
        }else{
            $todayReport = 'false';
        }
        //To add kaparo from the orders when branches are merged

        return \View::make('admin/safe/index', array('expected_price' => $allSold, 'todayReport' => $todayReport));
    }
}
