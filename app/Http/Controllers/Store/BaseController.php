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

class BaseController extends Controller
{
  public function __construct()
  {
    $materialTypes = MaterialType::all();
    $productothertypes = ProductOtherType::all();

    if(Auth::user()){
      $session_id = Auth::user()->getId();
      
      $countitems = Cart::session($session_id)->getTotalQuantity();

    }else{
        $countitems = 0;
    }

    View::share(['productothertypes' => $productothertypes, 'materialTypes' => $materialTypes, 'countitems' => $countitems]);
  }
}