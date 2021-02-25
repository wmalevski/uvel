<h3 style="margin: 5px 0; text-align: center;">Магазин за златна и сребърна бижутерия</h3>
<h3 style="margin: 5px 0; text-align: center;">{{ $store->name }} - {{ $store->location }}</h3>
<h4 style="margin: 5px 0; text-align: center;">тел.: {{ $store->phone }}</h4>
<hr/>

<h2 style="margin: 10px 0; text-align: center;"><b>Разсписка №: {{$payment->id}}</b></h2>
<h4 style="margin: 10px 0; text-align: center;">{{$payment->created_at->format('H:i d/m/Y')}}</h4>
<hr/>

@foreach($receipt_items as $item)
    <div style="clear: both;height:20px;"></div>
    @php
        $exchangedMaterials = ($exchangedMaterials == null && isset($item['orderExchangeMaterials']) && !empty($item['orderExchangeMaterials']) ? $item['orderExchangeMaterials'] : $exchangedMaterials);
    @endphp
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
    @case('material_exchange')
        @if(is_object($item['exchanged_materials']) && !empty($item['exchanged_materials']))
        <div style="width:100%;float:left;font-size:16px;"><b>Изкупуване на материали</b>:</div>
        <ul>
        @foreach($item['exchanged_materials'] as $mat)
            <li>
                <div style="float:left;width:58%;">{{$mat->material->name}} {{$mat->material->code}}, {{$mat->material->color}}</div>
                <div style="float:left;width:20%;text-align:right">{{$mat->material->prices->where('id', $mat->material_price_id)->first()->price}} лв. / гр.</div>
                <div style="float:left;width:20%;text-align:right">{{$mat->weight}} гр.</div>
            </li>
        @endforeach
        </ul>
        <hr/>
        <div style="width:70%;float:left;"><b>Тотал:</b></div>
        <div style="width:30%;float:left;text-align:right;">{{$item['exchanged_materials'][0]->sum_price}} лв.</div>
        <hr/>
        @endif
        @break
    @endswitch
    <div style="clear: both;height:20px;"></div>
@endforeach

@if(is_array($exchangedMaterials)&&!empty($exchangedMaterials))
<hr>
<div style="width:100%;float:left;"><b>Дадени материали от клиента:</b>
    <ul>
        @foreach($exchangedMaterials as $orderExchangeMaterial)
        <li>
            <div style="width:50%;float:left;"><b>Вид</b>: {{$orderExchangeMaterial['name']}}</div>
            <div style="width:50%;float:left;"><b>Тегло</b>: {{$orderExchangeMaterial['weight']}} гр.</div>
        </li>
        @endforeach
    </ul>
</div>
@endif

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