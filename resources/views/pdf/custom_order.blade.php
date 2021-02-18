<div style="text-align: center;">
    <div id="orderDetails" style="width:100%;">
        <div style="width:100%;margin:0;padding:0;text-align:center;"><h2>ПОРЪЧКА №: <b>{{$custom->id}}</b></h2></div>
        <br>
        <div style="width:50%;margin:0;padding:0;text-align:left;float:left;">
            <h3 style="display:inline;margin:0;padding:0"><i>Клиент</i></h3>
            Име: <b>{{$custom->name}}</b><br>
            Email: <b>{{$custom->email}}</b><br>
            Телефон: <b>{{ $custom->phone }}</b><br>
            Град: <b>{{ $custom->city }}</b><br>
        </div>
        <div style="width:50%;margin:0;padding:0;text-align:right;float:right;">
            Получена на: <b>{{$custom->created_at->format('d / m / Y')}}</b><br>
            Изпълнение До: <b>{{ $custom->deadline ? $custom->deadline->format('d / m / Y') : '___ / ___ / ______'}}</b>
            <br>
            Статус: <b>
            @switch($custom->status)
                @case('pending') Очаква одобрение@break;
                @case('accepted') Приет/В процес@break;
                @case('ready') Върнат от работилница@break;
                @default Получен@break;
            @endswitch</b>
        </div>
        <br style="clear:both;">
        <br style="clear:both;">
        <div style="width:100%;margin:0;padding:0;text-align:left;">Описание: <i>{{ $custom->content?:'____' }}</i></div>
        <br style="clear:both;">
        <div style="width:100%;margin:0;padding:0;text-align:left;">Оферта: <i>{{ $custom->offer?:'____' }}</i></div>
        <br style="clear:both;">
        <div style="width:100%;margin:0;padding:0;text-align:left;">Данни за готово изделие: <i>{{ $custom->ready_product?:'____' }}</i></div>
        <br style="clear:both;">
        <br style="clear:both;">
        <div style="width:100%;margin:0;padding:0;text-align:center;">
            <img style="max-width:100%;" src="{{ public_path("uploads/orders/".$custom->photos->first()['photo']) }}" />
        </div>

    </div>
</div>