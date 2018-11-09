<?php
namespace App\Http\Controllers\Store;

use App\MaterialType;
use App\ProductOtherType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
  public function __construct()
  {
    $materialTypes = MaterialType::all();
    $productothertypes = ProductOtherType::all();

    View::share(['productothertypes' => $productothertypes, 'materialTypes' => $materialTypes]);
  }
}