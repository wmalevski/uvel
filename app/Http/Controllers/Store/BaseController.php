<?php
namespace App\Http\Controllers\Store;

use Cart;
use Auth;
use App\MaterialType;
use App\ProductOtherType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use \Darryldecode\Cart\CartCondition as CartCondition;
use \Darryldecode\Cart\Helpers\Helpers as Helpers;
use Illuminate\Support\Facades\Session;
use App\Helpers\StoreNav;

class BaseController extends Controller{
	public function __construct(){
		new StoreNav;
		$countitems = 0;
		$materialTypes = MaterialType::all();
		$productothertypes = ProductOtherType::all();

		if(Auth::user()){
			$session_id = Auth::user()->getId();
			$countitems = Cart::session($session_id)->getTotalQuantity();
		}

		View::share(['productothertypes' => $productothertypes, 'materialTypes' => $materialTypes, 'countitems' => $countitems]);
	}
}