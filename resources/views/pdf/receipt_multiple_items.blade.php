<h3 style="margin: 5px 0; text-align: center;">Магазин за златна и сребърна бижутерия</h3>
<h3 style="margin: 5px 0; text-align: center;">{{ $store->name }} - {{ $store->location }}</h3>
<h4 style="margin: 5px 0; text-align: center;">тел.: {{ $store->phone }}</h4>
<hr/>

<h2 style="margin: 10px 0; text-align: center;"><strong>Разсписка за продадена стока №: {{ $payment->id }} <br> {{$payment->created_at}}</strong>
</h2>
<hr/>

@foreach($receipt_items as $item)
    @switch($item['type'])
    @case('product')
        <div style="width:70%;float:left;">Артикул: <b>{{$item['product']->name}}</b></div>
        <div style="width:30%;float:left;text-align:right;">{!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($item['product']->barcode, "EAN13",1,33,"black", true)) !!}</div>

        @if(isset($item['material']) && !empty($item['material']))
        <div style="width:100%;float:left;">Материал: <b>{{$item['material']->name}} {{$item['material']->code}}</b>, <b>{{$item['material']->color}}</b></div>
        @endif

        @if(isset($item['orderStones']) && !empty($item['orderStones']))
        <div style="width:100%;float:left;">Камъни:
            <ul>
            @foreach($item['orderStones'] as $stone)<li>{{$stone}}</li>@endforeach
            </ul>
        </div>
        @endif

        @if(isset($item['orderExchangeMaterials']) && !empty($item['orderExchangeMaterials']))
        <div style="width:100%;float:left;">Дадени материали от клиента:
            <ul>
            @foreach($orderExchangeMaterials as $orderExchangeMaterial)
                <li>
                    <div style="width:50%;float:left;">Вид: <b>{{$orderExchangeMaterial['name']}}</b></div>
                    <div style="width:50%;float:left;">Тегло: <b>{{$orderExchangeMaterial['weight']}}</b></div>
                </li>
            </ul>
            @endforeach
        </div>
        @endif

        @if(isset($item['material']) && !empty($item['material']) && strtolower($item['material']->name) == "злато")
        <div style="float: left; width: 33.3%;">Грам: <b>{{$item['weight']}}</b></div>
        <div style="float: left; width: 33.3%;">Изработка: <b>{{$item['product']->workmanship}} лв.</b></div>
        <div style="float: left; width: 33.3%;text-align: right;">Цена: <b>{{$item['product']->price}} лв.</b></div>
        @else
            @if($item['product']->gross_weight)
            <div style="float: left; width: 33.3%;">Грам: <b>{{$item['product']->gross_weight}} гр.</b></div>
            @endif

            @if($item['product']->workmanship)
            <div style="float: left; width: 33.3%;">Изработка: <b>{{$item['product']->workmanship}} лв.</b></div>
            @endif

            <div style="float: left; width: 33.3%;text-align: right;">Цена: <b>{{$item['product']->price }} лв.</b></div>
        @endif

        @break
    @case('box')
    @case('model')
        <div style="width:70%;float:left;">Артикул: <b>{{$item['product']->name}}</b>
            @if($item['type']=='model')<br>Размер: <b>{{$item->model_size}}</b>@endif
        </div>
        <div style="width:30%;float:left;text-align:right;">{!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($item['product']->barcode, "EAN13",1,33,"black", true)) !!}</div>
        <div style="clear: both"></div>
        @break
    @endswitch
    <div style="clear: both;height:50px;"></div>
@endforeach

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