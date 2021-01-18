<?php

namespace App\Http\Controllers;

use Auth;
use Response;
use App\Income;
use App\IncomeType;
use App\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use App\CashRegister;

class IncomeController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$income = Income::all();
		if(Auth::user()->role != 'admin') {
			$income = Income::where('store_id', Auth::user()->getStore()->id)->get();
		}

		$income_types = IncomeType::all();
		$currencies = Currency::all();
		$current_store = Auth::user()->getStore();

		return view('admin.income.index', compact('income', 'income_types', 'currencies', 'current_store'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		$validator = Validator::make($request->all(), array(
			'type_id' => 'required',
			'income_amount' => 'required',
			'currency_id' => 'required',
			'additional_info' => 'required'
		));

		if($validator->fails()){
			return Response::json(array('errors' => $validator->getMessageBag()->toArray()), 401);
		}

		$request->request->add(array(
			'amount' => $request->income_amount,
			'user_id' => Auth::user()->getId(),
			'store_id' => Auth::user()->getStore()->id
		));


		// Add the Income to the Cash Register
		$cashRegister = new CashRegister();
		$cashRegister->RecordIncome($request->income_amount, $request->currency_id, Auth::user()->getStore()->id);


		$income = Income::create($request->all());

		return Response::json(array('success' => View::make('admin/income/table', array('inc' => $income))->render()));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Income  $income
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, Income $income){
		$income_types = IncomeType::all();
		$currencies = Currency::all();

		return \View::make('admin/income/edit', array('income' => $income, 'income_types' => $income_types, 'currencies' => $currencies));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Income  $income
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Income $income){
		$validator = Validator::make($request->all(),array(
			'type_id' => 'required',
			'income_amount' => 'required',
			'income_amount_old' => 'required',
			'currency_id' => 'required',
			'currency_id_old' => 'required',
			'additional_info' => 'required'
		));

		if($validator->fails()){
			return Response::json(array('errors' => $validator->getMessageBag()->toArray()), 401);
		}

		$income->type_id = $request->type_id;
		$income->amount = $request->income_amount;
		$income->given = $request->given;
		$income->currency_id = $request->currency_id;
		$income->additional_info = $request->additional_info;
		$income->user_id = Auth::user()->getId();

		$income->save();


		// Reflect the change in the Cash Register
		$register = new CashRegister;
		$register::updateIncome($request->currency_id_old, $request->currency_id, $request->income_amount_old, $request->income_amount);


		return Response::json(array('ID' => $income->id, 'table' => View::make('admin/income/table', array('inc' => $income))->render()));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Income  $income
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Income $income){
		$income->delete();
		return Response::json(array('success' => 'Успешно изтрито!'));
	}
}