<div style="text-align: center;">
    <h3 style="font-size:14px;font-weight:bold;margin:0 0 5px 0;padding:0;">Магазин за златна и сребърна бижутерия</h3>
    <h3 style="font-size:14px;font-weight:bold;margin:0 0 5px 0 ;padding:0;">{{$store->name}} - {{$store->location}}</h3>
    <h3 style="font-size:12px;font-weight:normal;margin:0 0 5px 0;padding:0;">тел.: {{$store->phone}}</h3>

    <hr style="margin:10px 0 15px 0">

    <div id="orderDetails" style="width:100%;font-size:0;line-height:20px;">

        <div style="width:50%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">
            <div>ПОРЪЧКА №: <b>{{$order->id}}</b> / <b>{{$order->date_received}}</b></div>
            @if($model->name)<div>Модел: <b>{{$model->name}}</b></div>@endif
        </div>


        <div style="width:50%;margin:0;padding:0;font-size:10px;text-align:right;float:left;">
            <div>КЛИЕНТ: {{$order->customer_name}}</div>
            <div>ТЕЛ: <b>{{$order->customer_phone}}</b></div>
        </div>

        <hr style="margin:5px 0 5px 0;clear: both;height:0;width:0;">

        <div style="width:100%;margin:0;padding:0;font-size:10px;text-align:left;">
            @if($orderStones)<div>Камъни:
                @foreach($orderStones as $stone)
                    <b style="padding-right: 15px;">{{$stone}}</b>
                @endforeach
            </div>@endif
            <div>Материал: <b>{{$material->name}} {{$material->code}}, {{$material->color}}</b></div>

            <div style="clear: both;">
            @if (Illuminate\Support\Str::lower($material->name) == "злато")
                <div style="float: left; width: 33.3%;">Грам: <b>{{$order->weight}}</b></div>
                <div style="float: left; width: 33.3%;text-align:center;">Изработка: <b>{{$order->workmanship}}лв.</b></div>
                <div style="float: left; width: 33.3%;text-align:right;">Цена: <b>{{$order->price}}лв.</b></div>
            @else
                <div style="float: left; width: 33.3%;">Грам: <b>{{$order->gross_weight}}</b></div>
                <div style="float: left; width: 33.3%;text-align:center;">Изработка: <b>{{$order->workmanship}}лв.</b></div>
                <div style="float: left; width: 33.3%;text-align:right;">Цена: <b>{{$order->price}}лв.</b></div>
            @endif
            </div>
        </div>

        <hr style="margin:5px 0 5px 0;clear: both;height:0;width:0;">

        <div style="width:50%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">
            @if($order->earnest)Капаро: <b>{{$order->earnest}}лв.</b>@endif
        </div>

        <div style="width:100%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">
            @if ($orderExchangeMaterials)Дадени материали от клиента:
                @foreach($orderExchangeMaterials as $orderExchangeMaterial)
                    <div style="clear: both;">
                        <div style="float:left;width:50%;">Вид: <b>{{$orderExchangeMaterial['name']}}</b></div>
                        <div style="float:left;width:25%;">Тегло: <b>{{$orderExchangeMaterial['weight']}}гр</b></div>
                        <div style="float:left;width:25%;">Изкупува: <b>{{$orderExchangeMaterial['sum_price']}}лв</b></div>
                    </div>
                @endforeach
            @endif
        </div>

        <hr style="margin:5px 0 10px 0;clear: both;">

        @if ($order->content)
        <div style="font-size:12px;"><b>Описание:<b><br>{{ $order->content }}</div>
        @endif

        <div style="font-size:12px;float:left;width:50%;height:60px"><b>Клиент:<b></div>
        <div style="font-size:12px;float:left;width:50%;height:60px"><b>Приемчик:</b></div>

        <hr style="margin:5px 0 10px 0;clear: both;">

        <div style="float:left;width:50%;font-size:12px;"><b>За получаване: {{$order->date_returned}}</b></div>
        <div style="float:left;width:50%;padding-top:5px;">{!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($barcode, "EAN13",1,33,"black", true)) !!}</div>

    </div>
</div>