<h3 style="margin: 5px 0; text-align: center;">Магазин за златна и сребърна бижутерия</h3>
<h3 style="margin: 5px 0; text-align: center;">{{ $store->name }} - {{ $store->location }}</h3>
<h4 style="margin: 5px 0; text-align: center;">тел.: {{ $store->phone }}</h4>
<hr/>

<h2 style="margin: 10px 0; text-align: center;"><strong>ПОРЪЧКА №: {{ $order->id }} / {{$order->date_received}}</strong></h2>

<div>
    <strong>Клиент: </strong> {{$order->customer_name}}
</div>
<hr/>

<div>
    <strong>Тел: </strong> {{$order->customer_phone}}
</div>
<hr/>

@if($model->name)
<div>
    <strong>Модел: </strong> {{$model->name}}
</div>
<hr/>
@endif


<div>
    <strong>Материал: </strong> {{ $material->name }} - {{ $material->code }} - {{ $material->color }}
</div>
<hr/>

@if($orderStones)
    <h4>Камъни:</h4>
    @foreach($orderStones as $stone)
        <div>
            {{$stone}}
        </div>
    @endforeach
    <hr/>
@endif

@if (Illuminate\Support\Str::lower($material->name) == "злато")
    <div style="clear: both;">
        <div  style="float: left; width: 33.3%;">
            <strong>Грам: </strong> {{ $order->weight }}
        </div>
        <div  style="float: left; width: 33.3%;">
            <strong>Изработка: </strong> {{ $order->workmanship }} лв.
        </div>
        <div  style="float: left; width: 33.3%;">
            <strong>Цена: </strong> {{ $order->price }} лв.
        </div>
    </div>
    <hr/>
@else
    <div style="clear: both;">
        <div  style="float: left; width: 33.3%;">
            <strong>Грам: </strong> {{ $order->gross_weight }}
        </div>
        <div  style="float: left; width: 33.3%;">
            <strong>Изработка: </strong> {{ $order->workmanship }} лв.
        </div>
        <div  style="float: left; width: 33.3%;">
            <strong>Цена: </strong> {{ $order->price }} лв.
        </div>
    </div>
    <hr/>
@endif

@if($order->earnest)
    <div style="clear: both">
        <div style="float: left; width: 50%;">
            <strong>Капаро: {{$order->earnest}} лв.</strong>
        </div>
    </div>
    <hr/>
@endif

@if ($orderExchangeMaterials)
    <h4>Дадени материали от клиента:</h4>
    @foreach($orderExchangeMaterials as $orderExchangeMaterial)
        <div style="clear: both;">
            <div  style="float: left; width: 50%;">
                <strong>Вид: </strong> {{ $orderExchangeMaterial['name'] }}
            </div>
            <div  style="float: left; width: 50%;">
                <strong>Тегло: </strong> {{ $orderExchangeMaterial['weight'] }}
            </div>
        </div>
    @endforeach
    <hr/>
@endif

<div style="height: 100px">
    <strong>Описание: </strong> {{ $order->content }}
</div>
<hr/>

<div style="clear: both">
    <br>
    <div style="float: left; width: 50%;">
        <strong>Клиент:</strong>
    </div>
    <div style="float: left; width: 50%;">
        <strong style="margin-left: 200px;">Приемчик:</strong>
    </div>
    <br>
</div>
<hr/>

<div style="clear: both">
    <div  style="float: left; width: 70%;">
        <strong>Дата за получаване: {{$order->date_returned}}</strong>
    </div>

    <div style="float: left; width: 30%;">
        {!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($barcode, "EAN13",1,33,"black", true)) !!}
    </div>
</div>
