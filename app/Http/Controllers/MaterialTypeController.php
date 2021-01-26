<?php

namespace App\Http\Controllers;

use App\MaterialType;
use App\Jewel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Response;
use App\Material;

class MaterialTypeController extends Controller{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$materials = MaterialType::all();
		return \View::make('admin/materials_types/index', array('materials' => $materials));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		$validator = Validator::make( $request->all(), array('name'=>'required'));
		if($validator->fails()){
			return Response::json(array('errors'=>$validator->getMessageBag()->toArray()), 401);
		}

		$material = MaterialType::create($request->all());
		return Response::json(array('success' => View::make('admin/materials_types/table',array('material'=>$material))->render()));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\MaterialType  $materials_type
	 * @return \Illuminate\Http\Response
	 */
	public function edit(MaterialType $materialType){
		return \View::make('admin/materials_types/edit',array('material'=>$materialType));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\MaterialType  $materials_type
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, MaterialType $materialType){
		$validator = Validator::make($request->all(),array('name'=>'required'));
		if($validator->fails()){
			return Response::json(array('errors'=>$validator->getMessageBag()->toArray()), 401);
		}

		$materialType->name = $request->name;
		$materialType->site_navigation = ( $request->site_navigation == 'true'? 'yes' : 'no');
		$materialType->save();

		return Response::json(array('ID' => $materialType->id,'table' => View::make('admin/materials_types/table',array('material'=>$materialType))->render()));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\MaterialType  $materials_type
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(MaterialType $materialType){
		if($materialType){
			$using = Material::where('parent_id', $materialType->id)->count();

			if($using){
				return Response::json(array('errors'=>array('using'=>array('Този елемент се използва от системата и не може да бъде изтрит.'))), 401);
			}

			$materialType->delete();
			return Response::json(array('success'=>'Успешно изтрито!'));
		}
	}
}