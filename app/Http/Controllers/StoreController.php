<?php

namespace App\Http\Controllers;

use App\Store;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Response;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::all();
        return \View::make('admin/stores/index', array('stores' => $stores));
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
            'name' => 'required',
            'location' => 'required',
            'phone' => 'required|numeric',
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $store = Store::create($request->all());

        return Response::json(array('success' => View::make('admin/stores/table',array('store'=>$store))->render()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        $users = $store->users();

        return \View::make('admin/stores/store', array('users' => $users, 'store' => $store));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Store  $stores
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        return \View::make('admin/stores/edit', array('store' => $store));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'location' => 'required',
            'phone' => 'required|numeric',
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $store->name = $request->name;
        $store->location = $request->location;
        $store->phone = $request->phone;

        $store->save();

        return Response::json(array('ID' => $store->id, 'table' => View::make('admin/stores/table', array('store' => $store))->render()));
    }

    public function select_search(Request $request){
        $stores_new = new Store();
        $filteredStores = $stores_new->filterStores($request);
        return $filteredStores;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        if($store){

            $usingByUsers = $store->users()->count();
            $usingByMaterials = $store->materials()->count();
            $usingByProductsOther = $store->productsOther()->count();
            $usingByStones = $store->stones()->count();

            if($usingByUsers || $usingByMaterials || $usingByProductsOther || $usingByStones) {
                return Response::json(['errors' => ['using' => ['Този магазин се използва от системата и не може да бъде изтрит.']]], 401);
            }

            $store->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }
}
