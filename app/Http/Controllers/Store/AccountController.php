<?php

namespace App\Http\Controllers\Store;
use App\Product;
use App\ProductOther;
use App\ProductOtherType;
use App\Store;
use App\Material;
use App\MaterialType;
use App\Jewel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;

class AccountController extends BaseController{

	public function index(){
		if(!Auth::check()){
			return redirect()->route('login');
		}

		$sellings = Auth::user()->sellings;
		return \View::make('store.pages.account.index', array('sellings' => $sellings));
	}
}