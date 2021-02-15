<div style="text-align: center;">
    <div id="orderDetails" style="width:100%;">
        <div style="width:100%;margin:0;padding:0;text-align:center;"><h2>ПОРЪЧКА №: <b>{{$selling->id}}</b></h2></div>
        <br>
        <div style="width:50%;margin:0;padding:0;text-align:left;float:left;">
            <h3 style="display:inline;margin:0;padding:0"><i>Клиент</i></h3>
            Име: <b>{{$selling->user_payment->user->first_name}} {{$selling->user_payment->user->last_name}}</b><br>
            Email: <b>{{$selling->user_payment->user->email}}</b><br>
            @if($store_info)
                Телефон: <b>{{ $selling->user_payment->user->phone }}</b><br>
                Град: <b>{{ $selling->user_payment->user->city }}</b><br>
                За Магазин: <b>{{ $store_info->name }}, {{ $store_info->location }}
            @else
                Телефон: <b>{{ $selling->user_payment->phone }}</b><br>
                Град: <b>{{ $selling->user_payment->city }}</b><br>
                Адрес: <b>{{ $selling->user_payment->shipping_address }}</b>
            @endif
        </div>
        <div style="width:50%;margin:0;padding:0;text-align:right;float:right;">
            Получена на: <b>{{$selling->created_at->format('d / m / Y')}}</b><br>
            Изпълнение До: <b>{{ $selling->deadline ? $selling->deadline->format('d / m / Y') : '___ / ___ / ______'}}</b><br><br>
            Статус: <b>
            @switch($selling->model_status)
                @case('pending') Очаква одобрение@break;
                @case('accepted') Приет/В процес@break;
                @case('ready') Върнат от работилница@break;
                @default Получен@break;
            @endswitch</b>
        </div>
        <br style="clear:both;">
        <br style="clear:both;">
        <div style="width:100%;margin:0;padding:0;text-align:left;">Описание: <i>{{ $selling->user_payment->information?:'____' }}</i></div>
        <br style="clear:both;">
        <br style="clear:both;">
        <br style="clear:both;">
        <br>
        <div style="width:15%;margin:0;padding:0;text-align:left;float:left;"><b>Модел №</b></div>
        <div style="width:25%;margin:0;padding:0;text-align:left;float:left;"><b>Име</b></div>
        <div style="width:25%;margin:0;padding:0;text-align:left;float:left;"><b>Баркод</b></div>
        <div style="width:35%;margin:0;padding:0;text-align:right;float:left;"><b>Размер</b></div>
        <br style="clear:both;">
        <div style="width:15%;margin:0;padding:0;text-align:left;float:left;">{{$selling->model_id}}</div>
        <div style="width:25%;margin:0;padding:0;text-align:left;float:left;">{{$selling->model->name}}</div>
        <div style="width:25%;margin:0;padding:0;text-align:left;float:left;">{{$selling->model->barcode}}</div>
        <div style="width:35%;margin:0;padding:0;text-align:right;float:left;">{{$selling->model_size}}</div>
        <br style="clear:both;">
        <br style="clear:both;">
        <br style="clear:both;">
        <div style="width:100%;margin:0;padding:0;text-align:center;">
            <img style="max-width:100%;" src="{{ asset("uploads/models/" . $selling->photos->first()['photo']) }}" />
        </div>

    </div>
</div>