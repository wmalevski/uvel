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
     * @param  \App\CorporatePartnerMaterial  $corporatePartnerMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(CorporatePartnerMaterial $corporatePartnerMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CorporatePartnerMaterial  $corporatePartnerMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(CorporatePartnerMaterial $corporatePartnerMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CorporatePartnerMaterial  $corporatePartnerMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CorporatePartnerMaterial $corporatePartnerMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CorporatePartnerMaterial  $corporatePartnerMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(CorporatePartnerMaterial $corporatePartnerMaterial)
    {
        //
    }
}
