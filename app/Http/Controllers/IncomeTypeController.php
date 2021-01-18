<?php

namespace App\Http\Controllers;

use Response;
use App\IncomeType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class IncomeTypeController extends Controller{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$incomeTypes = IncomeType::all();

		return view('admin.income_types.index', compact('incomeTypes'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		$validator = Validator::make( $request->all(), array('name' => 'required'));

		if($validator->fails()){
			return Response::json(array('errors' => $validator->getMessageBag()->toArray()), 401);
		}

		$type = IncomeType::create($request->all());

		return Response::json(array('success' => View::make('admin/income_types/table',array('type'=>$type))->render()));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\IncomeType  $incomeType
	 * @return \Illuminate\Http\Response
	 */
	public function edit(IncomeType $type){
		return \View::make('admin/income_types/edit',array('type'=>$type));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\IncomeType  $incomeType
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, IncomeType $type){
		$validator = Validator::make( $request->all(), array('name' => 'required'));

		if($validator->fails()){
			return Response::json(array('errors' => $validator->getMessageBag()->toArray()), 401);
		}

		$type->name = $request->name;

		$type->save();

		return Response::json(array('ID' => $type->id, 'table' => View::make('admin/income_types/table',array('type'=>$type))->render()));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\IncomeType  $incomeType
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(IncomeType $type){
		$type->delete();
		return Response::json(array('success' => 'Успешно изтрито!'));
	}
}