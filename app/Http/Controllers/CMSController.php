<?php

namespace App\Http\Controllers;

use App\CMS;
use Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CMSController extends Controller{

	public function ListBlocks(){
		$CMS = CMS::orderBy('friendly_name','ASC')->get();
		return \View::make('admin/cms/list', array('info_blocks' => $CMS));
	}

	// GET
	public function EditBlock($info_block){
		return \View::make('admin/cms/edit', array(
			'key' => $info_block,
			'value' => CMS::get($info_block),
			'friendly_name' => CMS::get($info_block, true)
		));
	}

	// POST
	public function Update($info_block, Request $request){
		if(!$info_block && $info_block==''){
			return Response::json(array('errors' => 'Info block key not set'), 401);
		}

		$validator = Validator::make($request->all(),array('block_value'=>'required'));
		if($validator->fails()){
			return Response::json(array('errors'=>$validator->getMessageBag()->toArray()), 401);
		}

		CMS::set($info_block, $request->block_value);

		return Response::json('SUCCESS', 200);
	}
}