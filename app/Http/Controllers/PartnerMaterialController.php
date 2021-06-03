<?php

namespace App\Http\Controllers;

use App\Partner;
use App\PartnerMaterial;
use App\Material;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Response;

class PartnerMaterialController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($partner){
        $partner = Partner::find($partner);

        if($partner){
            $partner_materials = array();

            $materials = Material::all();

            foreach($partner->materials as $k=>$v){
                if(!isset($partner_materials[$v->material_id])){
                    $partner_materials[$v->material_id]=0;
                }
                $partner_materials[$v->material_id]+=$v->quantity;
            }

            return \View::make('admin/partner_materials/index', array(
                'partner' => $partner,
                'partner_materials' => $partner_materials,
                'materials' => $materials
            ));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PartnerMaterial  $PartnerMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner, $material){
        $quantity = PartnerMaterial::where(array(
            array('partner_id',$partner->id),
            array('material_id',$material)
        ))->first();
        $quantity = (isset($quantity->quantity)?$quantity->quantity:0);
        return \View::make('admin/partner_materials/edit', array(
            'partner'=>$partner,
            'material'=>$material,
            'quantity'=>$quantity
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PartnerMaterial  $PartnerMaterial
     * @return \Illuminate\Http\Response
     */
    public function update($partner, $material, Request $request){
        $validator = Validator::make( $request->all(), [
            'quantity' => 'required',
        ]);
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }
        $materialID=$material;
        $material = PartnerMaterial::where(array(
            'partner_id'=>$partner,
            'material_id'=>$material
        ))->first();

        // Update
        if(isset($material->material_id) && $material->material_id==$materialID){
            $material->quantity=$request->quantity;
        }
        else{
            $material = new PartnerMaterial();
            $material->partner_id=$partner;
            $material->material_id=$materialID;
            $material->quantity=$request->quantity;
        }

        $material->save();

        $partner=Partner::where('id',$partner)->first();
        $material=Material::where('id',$materialID)->first();

        return Response::json(array('ID' => $materialID, 'table' => View::make('admin/partner_materials/table', array(
            'partner'=>$partner,
            'material'=>$material,
            'partner_materials'=>array($material->id=>$request->quantity)
        ))->render()));
    }

}