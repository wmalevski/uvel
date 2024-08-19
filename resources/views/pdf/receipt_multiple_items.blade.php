<h3 style="margin: 5px 0; text-align: center;">Магазин за златна и сребърна бижутерия</h3>
<h3 style="margin: 5px 0; text-align: center;">{{ $store->name }} - {{ $store->location }}</h3>
<h4 style="margin: 5px 0; text-align: center;">тел.: {{ $store->phone }}</h4>
<hr/>

<h2 style="margin: 10px 0; text-align: center;"><b>Разписка №: {{$payment->id}}</b></h2>
<h4 style="margin: 10px 0; text-align: center;">{{$payment->created_at->format('H:i d/m/Y')}}</h4>
<hr/>

@foreach($receipt_items as $item)
    <div style="clear: both;height:20px;"></div>
    @php
        $exchangedMaterials = ($exchangedMaterials == null && isset($item['orderExchangeMaterials']) && !empty($item['orderExchangeMaterials']) ? $item['orderExchangeMaterials'] : $exchangedMaterials);
    @endphp
    @switch($item['type'])
    @case('product')
        <div style="width:70%;float:left;"><b>Артикул</b>: {{$item['product']->name}}</div>
        <div style="width:30%;float:left;text-align:right;">{!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($item['product']->barcode, "EAN13",1,33,"black", true)) !!}</div>

        @if(isset($item['material']) && !empty($item['material']))
        <div style="width:100%;float:left;"><b>Материал</b>: {{$item['material']->name}} {{$item['material']->code}}, {{$item['material']->color}}</div>
        @endif

        @if(isset($item['orderStones']) && !empty($item['orderStones']))
        <div style="width:100%;float:left;"><b>Камъни</b>:
            <ul>
            @foreach($item['orderStones'] as $stone)<li>{{$stone}}</li>@endforeach
            </ul>
        </div>
        @endif

        @if(isset($item['material']) && !empty($item['material']))
            @php
                $totalWeight += $item['product']->weight;
                $totalPrice += $item['product']->price;
            @endphp
            <div style="float:left;width:33.3%;"><b>Грам</b>: {{$item['product']->weight}} гр.</div>

            @if($item['product']->workmanship)
                <div style="float:left;width:33.3%;"><b>Изработка</b>: {{$item['product']->workmanship}} лв.</div>
            @endif
            <div style="float:left;width:33.3%;text-align:right;"><b>Цена</b>: {{$item['product']->price }} лв.</div>
        @endif

        @break
    @case('box')
    @case('model')
        <div style="width:70%;float:left;"><b>Артикул</b>: {{$item['product']->name}}
            @if($item['type']=='model')<br><b>Размер</b>: {{$item->model_size}}@endif
        </div>
        <div style="width:30%;float:left;text-align:right;">{!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($item['product']->barcode, "EAN13",1,33,"black", true)) !!}</div>
        <div style="clear: both"></div>
        @if($item['type']=='box')
        <div style="float:left;width:100%;text-align:right;"><b>Цена</b>: {{$item['product']->price }} лв.</div>
        <br>
        @endif
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
@endforeach

<div style="clear: both;height:20px;"></div>

<div style="text-align:right;"><b>Обменен материал</b>: {{$exchange_material_sum}}лв.</div>
<div style="text-align:right;"><b>Дадена сума</b>: {{$payment->given}} лв.</div>
<div style="text-align:right;"><b>Ресто</b>: {{ floatval( ($exchange_material_sum + $payment->given) - $payment->price )}}лв.</div>


<hr />
<div style="width:50%;float:left;"><b>Общо тегло</b>: {{$totalWeight}} гр.</div>
<div style="width:50%;float:left;text-align:right"><b>Продуктова цена</b>: {{$totalPrice}} лв.</div>

<div style="clear: both;height:20px;"></div>

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
    <div style="float: left; width: 50%;"><b>Клиент:</b></div>
    <div style="float: left; width: 50%;"><b style="margin-left: 200px;">Приемчик:</b></div>
    <br>
</div>
