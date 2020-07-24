<h3 style="margin: 5px 0; text-align: center;">Магазин за златна и сребърна бижутерия</h3>
<h3 style="margin: 5px 0; text-align: center;">{{ $store->name }} - {{ $store->location }}</h3>
<h4 style="margin: 5px 0; text-align: center;">тел.: {{ $store->phone }}</h4>
<hr/>

<h2 style="margin: 10px 0; text-align: center;"><strong>Разсписка за продадена стока №: {{ $payment->id }} <br> {{$payment->created_at}}</strong>
</h2>
<hr/>
@if(isset($product))
    <div>
        <strong>Артикул: </strong> {{$product->name}}
    </div>
    <hr/>
@endif

@if(isset($material) && !empty($material))
    <div>
        <strong>Материал: </strong> {{ $material->name }} - {{ $material->code }} - {{ $material->color }}
    </div>
    <hr/>
@endif

@if(isset($orderStones) && !empty($orderStones))
    <h4>Камъни:</h4>
    @foreach($orderStones as $stone)
        <div>
            {{$stone}}
        </div>
    @endforeach
    <hr/>
@endif

@if (isset($orderExchangeMaterials) && !empty($orderExchangeMaterials))
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

@if (isset($material) && !empty($material) && Illuminate\Support\Str::lower($material->name) == "злато")
    <div style="clear: both;">
        <div  style="float: left; width: 33.3%;">
            <strong>Грам: </strong> {{ $product->weight }}
        </div>
        <div  style="float: left; width: 33.3%;">
            <strong>Изработка: </strong> {{ $product->workmanship }} лв.
        </div>
        <div  style="float: left; width: 33.3%;">
            <strong>Цена: </strong> {{ $product->price }} лв.
        </div>
    </div>
    <hr/>
@else
    <div style="clear: both;">
        @if($product->gross_weight)
        <div  style="float: left; width: 33.3%;">
            <strong>Грам: </strong> {{ $product->gross_weight }}
        </div>
        @endif
        @if($product->workmanship)
        <div  style="float: left; width: 33.3%;">
            <strong>Изработка: </strong> {{ $product->workmanship }} лв.
        </div>
        @endif
        <div  style="float: left; width: 33.3%;">
            <strong>Цена: </strong> {{ $product->price }} лв.
        </div>
    </div>
    <hr/>
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

<div style="clear: both">
    <div style="float: left; width: 30%;">
        {!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($barcode, "EAN13",1,33,"black", true)) !!}
    </div>
</div>
