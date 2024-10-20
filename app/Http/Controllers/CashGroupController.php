<?php

namespace App\Http\Controllers;

use App\CashGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Response;

class CashGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cashgroups  = CashGroup::all();
    
        return view('admin.settings.cashgroups.index', compact('cashgroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param CashGroup $cashGroup
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CashGroup $cashGroup)
    {
        $validator = Validator::make( $request->all(), [
            'cash_group' => 'required|integer',
            'label' => 'required|string',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $cashGroup->cash_group = $request->cash_group;
        $cashGroup->label = $request->label;
        $cashGroup->save();

        return Response::json(array('ID' => $cashGroup->id, 'success' => View::make('admin/settings/cashgroups/table', array('cashgroup' => $cashGroup))->render()));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CashGroup  $cashGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(CashGroup $cashGroup)
    {
        return \View::make('admin/settings/cashgroups/edit', array('cashgroup' => $cashGroup));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CashGroup  $cashGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CashGroup $cashGroup)
    {
        $validator = Validator::make( $request->all(), [
            'cash_group' => 'required|integer',
            'label' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $cashGroup->cash_group = $request->cash_group;
        $cashGroup->label = $request->label;
        $cashGroup->save();
        
        return Response::json(array('ID' => $cashGroup->id, 'table' => View::make('admin/settings/cashgroups/table', array('cashgroup' => $cashGroup))->render()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CashGroup  $cashGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(CashGroup $cashGroup)
    {
        $cashGroup = CashGroup::find($cashGroup)->first();

        if($cashGroup){
            $cashGroup->delete();

            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
