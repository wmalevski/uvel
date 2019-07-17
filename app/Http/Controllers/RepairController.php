<?php

namespace App\Http\Controllers;

use Response;
use App\Price;
use App\Repair;
use App\RepairType;
use App\Material;
use App\History;
use Auth;
use Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\MaterialQuantity;

class RepairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repairTypes = RepairType::take(env('SELECT_PRELOADED'))->get();
        $repairs = Repair::all();
        $materials = Material::take(env('SELECT_PRELOADED'))->get();
        
        return \View::make('admin/repairs/index', array('repairTypes' => $repairTypes, 'repairs' => $repairs, 'materials' => $materials));
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
        $validator = Validator::make( $request->all(), [
            'customer_name' => 'required',
            "customer_phone" => 'required|phone',
            'type_id' => 'required',
            'date_returned' => 'required',
            'weight' => 'required|numeric',
            'price' => 'required|numeric|between:0.1,5000'
         ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $repair = Repair::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'type_id' => $request->type_id,
            'date_recieved' => $request->date_recieved,
            'date_returned' => $request->date_returned,
            'code' =>  'R-' . unique_code('products', 'code'),
            'weight' => $request->weight,
            'price' => $request->price,
            'repair_description' => $request->repair_description,
            'material_id' => $request->material_id,
            'status' => 'repairing'
        ]);
        
        $bar = '380'.unique_number('repairs', 'barcode', 7).'1'; 

        $digits =(string)$bar;
        // 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
        $even_sum = $digits{1} + $digits{3} + $digits{5} + $digits{7} + $digits{9} + $digits{11};
        // 2. Multiply this result by 3.
        $even_sum_three = $even_sum * 3;
        // 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
        $odd_sum = $digits{0} + $digits{2} + $digits{4} + $digits{6} + $digits{8} + $digits{10};
        // 4. Sum the results of steps 2 and 3.
        $total_sum = $even_sum_three + $odd_sum;
        // 5. The check character is the smallest number which, when added to the result in step 4,  produces a multiple of 10.
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;
        $repair->barcode = $digits . $check_digit;

        $repair->save();

        return Response::json(array('success' => View::make('admin/repairs/table',array('repair'=>$repair))->render(), 'id' => $repair->id));
    }

    public function scan($barcode){
        $repair = Repair::where('barcode', $barcode)->get();

        return Response::json(array('repair' => $repair));
    }

    public function certificate($id){
        $repair = Repair::find($id);
        return Response::json(array('success' => 'yes', 'html' => View::make('admin/repairs/certificate',array('repair'=>$repair))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Repair  $repairs
     * @return \Illuminate\Http\Response
     */
    public function show(Repair $repair)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Repair  $repairs
     * @return \Illuminate\Http\Response
     */
    public function edit(Repair $repair, $barcode)
    {
        $repair = Repair::where('barcode', $barcode)->first();
        $repairTypes = RepairType::take(env('SELECT_PRELOADED'))->get();
        $materials = Material::take(env('SELECT_PRELOADED'))->get();

        return \View::make('admin/repairs/edit', array('repair' => $repair, 'repairTypes' => $repairTypes, 'materials' => $materials));
    }


    public function return(Repair $repair, $code)
    {
        $repair = Repair::where('code', $code)->first();
        $repairTypes = RepairType::all();

        if($repair){
            if($repair->status == 'done'){
                $userId = Auth::user()->getId(); 
                
                Cart::clear();
                Cart::clearCartConditions();
                Cart::session($userId)->clear();
                Cart::session($userId)->clearCartConditions();
        
                $price = $repair->price;
                $weight = $repair->weight;
        
                if($repair->price_after != ''){
                    $price = $repair->price_after;
                }
        
                if($repair->weight_after != ''){
                    $weight = $repair->weight_after;
                }
        
                Cart::session($userId)->add(array(
                    'id' => $repair->code,
                    'name' => 'Връщане на ремонт - '.$repair->customer_name,
                    'price' => $price,
                    'quantity' => 1,
                    'attributes' => array(
                        'weight' => $weight,
                        'type' => 'repair'
                    )
                ));
        
                // $tax = new \Darryldecode\Cart\CartCondition(array(
                //     'name' => 'ДДС',
                //     'type' => 'tax',
                //     'target' => 'subtotal',
                //     'value' => '+20%',
                //     'attributes' => array(
                //         'description' => 'Value added tax',
                //         'more_data' => 'more data here'
                //     )
                // ));
        
                // Cart::condition($tax);
                // Cart::session($userId)->condition($tax);
        
                //return redirect()->route('admin');
                return Response::json(array('success' => '', 'redirect' => route('admin')));
            }elseif($repair->status == 'returned') {
                return Response::json(['errors' => ['not_done' => ['Ремонтът е отбелязан като завършен.']]], 401);
            }else{
                return Response::json(['errors' => ['not_done' => ['Ремонтът не е отбелязан като завършен и готов за връщане.']]], 401);
            }
        }else{
            return Response::json(['errors' => ['not_exist' => ['Не съществува такъв ремонт.']]], 401);
        }

        //return \View::make('admin/repairs/return', array('repair' => $repair, 'repairTypes' => $repairTypes));

        
    }

    public function returnRepair(Request $request, Repair $repair)
    {
        $repair = Repair::where('code', $repair)->first();

        if($repair){
            $repair->status = 'returned';
            $repair->date_received = Carbon::parse(Carbon::now())->format('d-m-Y');

            $repair->customer_name = $request->customer_name;
            $repair->customer_phone = $request->customer_phone;
            $repair->date_returned = $request->date_returned;
            $repair->price_after = $request->price_after; 
            $repair->repair_description = $request->repair_description;
            $repair->material_id = $request->material_id;
            $repair->weight_after = $request->weight_after;
            $repair->type_id = $request->type_id;
            
            $repair->save();

            // $history = new History;
            // $history->action = 'repair';
            // $history->user = Auth::user()->id;
            // $history->result_id = $repair->id;

            return Response::json(array('table' => View::make('admin/repairs/table',array('repair'=>$repair))->render(), 'ID' => $repair->id));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Repair  $repairs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $barcode)
    {

        $repair = Repair::where('barcode', $barcode)->first();
        if($request->status == 'true'){
            $repair->status = 'done';

            // $history = new History;
            // $history->action = 'repair';
            // $history->user = Auth::user()->id;
            // $history->result_id = $repair->id;
            // $history->save();
        }else{
            $repair->status = 'repairing';
        }

        $validator = Validator::make( $request->all(), [
            'customer_name' => 'required',
            'customer_phone' => 'required|phone',
            'type_id' => 'required',
            'date_returned' => 'required',
            'weight' => 'required|numeric',
            'price' => 'required|numeric|between:0.1,5000',
            'price_after' => 'required|numeric|between:0.1,5000',
            'weight_after' => 'required|numeric'
         ]);

         if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

         $repair->customer_name = $request->customer_name;
         $repair->customer_phone = $request->customer_phone;
         $repair->date_returned = $request->date_returned;
         $repair->price_after = $request->price_after; 
         $repair->repair_description = $request->repair_description;
         $repair->material_id = $request->material_id;
         $repair->weight_after = $request->weight_after;
         $repair->type_id = $request->type_id;

        if($repair->weight < $request->weight_after){
            //check for material quantity
            $materialQuantity = MaterialQuantity::where('material_id', $request->material_id)->first();

            if($materialQuantity){
                if($materialQuantity->quantity > $request->weight_after){
                    $materialQuantity->quantity = $materialQuantity->quantity - ($request->weight_after - $request->weight);
                    $materialQuantity->save();
                }else{
                    return Response::json(['errors' => ['not_quantity' => ['Няма достатъчна наличност от този материал.']]], 401);
                }
            }
        }
    
        $repair->save();
        
        return Response::json(array('ID' => $repair->id, 'table' => View::make('admin/repairs/table',array('repair'=>$repair))->render(), 'ID' => $repair->id));
    }

    public function filter(Request $request){
        $query = Repair::select('*');

        $repairs_new = new Repair();
        $repairs = $repairs_new->filterRepairs($request, $query);
        $repairs = $repairs->paginate(env('RESULTS_PER_PAGE'));

        $response = '';
        foreach($repairs as $repair){
            $response .= \View::make('admin/repairs/table', array('repair' => $repair, 'listType' => $request->listType));
        }

        $repairs->setPath('');
        $response .= $repairs->appends(Input::except('page'))->links();

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Repair  $repairs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repair $repair)
    {
        $repair = Repair::find($repair)->first();

        if($repair){
            $repair->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
