<?php

namespace App\Http\Controllers\Store;
use App\UserPayment;
use Auth;
use Response;
use App\Model;
use App\ModelOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Mail;

class ModelOrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = ModelOrder::where('user_id', Auth::user()->getId())->get();

        return \View::make('store.pages.user.orders', array('orders' => $orders));
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
    public function store(Request $request, $model)
    {
        $model = Model::find($model);

        if($model){
            $order = new ModelOrder();
            $order->model_id = $model->id;
            $order->user_id = Auth::user()->getId();
            $order->save();

            //send sms to the admin
            Mail::send('sms',
                array(
                    'content' => "Porychka katalog! ID $model->id"
                ), function($message) {
                    $message->from("info@uvel.bg");
                    $message->to("359888514714@sms.telenor.bg")->subject('Katalog');
            });

            return Response::json(array('success' => 'Поръчката беше изпратена успешно. Можете да следите найният статус в страницата с поръчки във вашият профил!'));
        }else{
            return Response::json(array('error' => 'Този модел не беше намерен в системата. Моля опитайте по-късно!'), 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ModelOrder  $modelOrder
     * @return \Illuminate\Http\Response
     */
    public function show(ModelOrder $modelOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ModelOrder  $modelOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(ModelOrder $modelOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ModelOrder  $modelOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModelOrder $modelOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ModelOrder  $modelOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelOrder $modelOrder)
    {
        //
    }
}
