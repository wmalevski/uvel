<h3 style="margin: 5px 0; text-align: center;">Магазин за златна и сребърна бижутерия</h3>
<h3 style="margin: 5px 0; text-align: center;">{{ $store->name }} - {{ $store->location }}</h3>
<h4 style="margin: 5px 0; text-align: center;">тел.: {{ $store->phone }}</h4>
<hr/>

<h2 style="margin: 10px 0; text-align: center;"><b>Разсписка за продадена стока №: {{ $payment->id }}</b></h2>
<h4 style="margin: 10px 0; text-align: center;">{{$payment->created_at->format('H:i d/m/Y')}}</h4>
</h2>
<hr/>
<br><br>
@if(isset($product))
<div style="width:70%;float:left;"><b>Артикул</b>: {{$product->name}}</div>
<div style="width:30%;float:left;text-align:right;">{!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($barcode, "EAN13",1,33,"black", true)) !!}</div>
@endif

@if(isset($material) && !empty($material))
<div style="width:100%;float:left;"><b>Материал</b>: {{$material->name}} {{$material->code}}, {{$material->color}}</div>
@endif

@if(isset($orderStones) && !empty($orderStones))
    <div style="width:100%;float:left;"><b>Камъни</b>:
        <ul>
            @foreach($orderStones as $stone)<li>{{$stone}}</li>@endforeach
        </ul>
    </div>
@endif

@if(isset($material) && !empty($material))
    <div style="float:left;width:33.3%;"><b>Грам</b>:
        {{(strtolower($material->name)!=="злато" && $product->gross_weight ? $product->gross_weight : $product->weight )}} гр.</div>

    @if($product->workmanship)
        <div style="float:left;width:33.3%;"><b>Изработка</b>: {{$product->workmanship}} лв.</div>
    @endif
    <div style="float:left;width:33.3%;text-align:right;"><b>Цена</b>: {{$product->price }} лв.</div>
@endif

<div style="clear: both;height:20px;"></div>

<div style="text-align:right;"><b>Обменен материал</b>: {{$exchange_material_sum}}лв.</div>
<div style="text-align:right;"><b>Дадена сума</b>: {{$payment->given}} лв.</div>
<div style="text-align:right;"><b>Ресто</b>: {{ floatval( ($exchange_material_sum + $payment->given) - $payment->price )}}лв.</div>

<div style="clear: both;height:20px;"></div>

@if(isset($orderExchangeMaterials) && !empty($orderExchangeMaterials))
    <hr/>
    <div style="width:100%;float:left;"><b>Дадени материали от клиента:</b>
        <ul>
        @foreach($orderExchangeMaterials as $orderExchangeMaterial)
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