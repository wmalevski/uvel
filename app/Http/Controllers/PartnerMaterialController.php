<?php

namespace App\Http\Controllers;

use App\Partner;
use App\PartnerMaterial;
use Illuminate\Http\Request;

class PartnerMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($partner)
    {
        $partner = Partner::find($partner);

        if($partner){
            $materials = $partner->materials;

            return \View::make('admin/partner_materials/index', array('materials' => $materials, 'partner' => $partner));
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PartnerMaterial  $PartnerMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(PartnerMaterial $PartnerMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PartnerMaterial  $PartnerMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner, PartnerMaterial $material)
    {
        return \View::make('admin/partner_materials/edit', array('material' => $material,'partner' => $partner));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PartnerMaterial  $PartnerMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartnerMaterial $material, Partner $partner)
    {
        $validator = Validator::make( $request->all(), [
            'quantity' => 'required',
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $material->quantity = $request->quantity;
        
        $material->save();
        
        return Response::json(array('ID' => $material->id, 'table' => View::make('admin/partner_materials/table', array('partner' => $partner, 'material' => $material))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PartnerMaterial  $PartnerMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartnerMaterial $PartnerMaterial)
    {
        //
    }
}
