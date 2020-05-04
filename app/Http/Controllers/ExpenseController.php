<?php

namespace App\Http\Controllers;

use Auth;
use Response;
use App\Expense;
use App\ExpenseType;
use App\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if(Auth::user()->role != 'admin') {
      $expenses = Expense::where('store_from_id', Auth::user()->getStore()->id)->orWhere('store_to_id', Auth::user()->getStore()->id)->get();
    } else {
      $expenses = Expense::all();
    }
    $expenses_types = ExpenseType::all();
    $currencies = Currency::all();
    $current_store = Auth::user()->getStore();

    return view('admin.expenses.index', compact('expenses', 'expenses_types', 'currencies', 'current_store'));
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
    $validator = Validator::make($request->all(), [
      'type_id'           => 'required',
      'expense_amount'    => 'required',
      'currency_id'       => 'required',
      'additional_info'   => 'required'
    ]);

    if ($validator->fails()) {
      return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
    }

    $request->request->add(['amount' => $request->expense_amount]);
    $request->request->add(['user_id' => Auth::user()->getId()]);
    $request->request->add(['store_from_id' => Auth::user()->getStore()->id]);

    if($request->send_to_store == true) {
        $request->request->add(['store_to_id' => $request->store_to_id]);
    }

    $expense = Expense::create($request->all());

    return Response::json(array('success' => View::make('admin/expenses/table', array('expense' => $expense))->render()));
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Expenses  $expenses
   * @return \Illuminate\Http\Response
   */
  public function show(Expense $expense)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Expense  $expenses
   * @return \Illuminate\Http\Response
   */
  public function edit(Expense $expense)
  {
    $expenses_types = ExpenseType::all();
    $currencies = Currency::all();

    return \View::make('admin/expenses/edit', array('expense' => $expense, 'expenses_types' => $expenses_types, 'currencies' => $currencies));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Expenses  $expenses
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Expense $expense)
  {
    $validator = Validator::make($request->all(), [
      'type_id' => 'required',
      'expense_amount' => 'required',
      'currency_id' => 'required',
      'additional_info'   => 'required'
    ]);

    if ($validator->fails()) {
      return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
    }

    $expense->type_id = $request->type_id;
    $expense->amount = $request->expense_amount;
    $expense->given = $request->given;
    $expense->currency_id = $request->currency_id;
    $expense->additional_info = $request->additional_info;
    $expense->user_id = Auth::user()->getId();

    $expense->save();

    return Response::json(array('ID' => $expense->id, 'table' => View::make('admin/expenses/table', array('expense' => $expense))->render()));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Expenses  $expenses
   * @return \Illuminate\Http\Response
   */
  public function destroy(Expense $expense)
  {
    $expense->delete();
    return Response::json(array('success' => 'Успешно изтрито!'));
  }
}
