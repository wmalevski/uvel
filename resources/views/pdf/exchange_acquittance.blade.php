<h3 style="margin: 5px 0; text-align: center;">Магазин за златна и сребърна бижутерия</h3>
<h3 style="margin: 5px 0; text-align: center;">{{ $store->name }} - {{ $store->location }}</h3>
<h4 style="margin: 5px 0; text-align: center;">тел.: {{ $store->phone }}</h4>

<hr/>
<div>
    <strong>Дата: </strong> {{ date("d-m-Y",strtotime($payment->created_at)) }}
</div>
<hr/>
<h2 style="margin: 10px 0; text-align: center;"><strong>№: {{ $payment->id }}</strong></h2>
<h3 style="margin: 5px 0 20px; text-align: center;">Разписка за закупен материал</h3>
<hr/>
@foreach ($materials as $material)
    <div style="clear: both;">
        <div  style="float: left; width: 100%;">
            <strong>Материал: </strong> {{ $material['name'] }}
        </div>
    </div>
    <div style="clear: both;">
        <div  style="float: left; width: 50%;">
            <strong>Тегло: </strong> {{ $material['weight'] }}
        </div>
        <div  style="float: left; width: 50%;">
            @if(!is_null($material['carat']))
                <strong>Карат: </strong> {{ $material['carat'] }}
            @endif
        </div>
    </div>
    <div style="clear: both;">
        <div  style="float: left; width: 50%;">
            @if(!is_null($material['carat']))
                <strong>Тегло в 14к: </strong> {{ $material['weight'] }}
            @endif
        </div>
        <div  style="float: left; width: 50%;">
            <strong>Цена за грам: </strong> {{ $material['price_per_weight'] }}
        </div>
    </div>
    <hr/>
@endforeach
<div style="clear: both;">
    <div  style="float: left; width: 50%;">
        <strong>Платено:({{$currency->name}})</strong>
    </div>
    <div  style="float: left; width: 50%;">
        <strong>Ресто:({{$currency->name}})</strong>
    </div>
</div>
<hr/>
<div style="clear: both">
    <div style="float: left; width: 50%;">
        <strong>Клиент:</strong>
    </div>
    <div style="float: left; width: 50%;">
        <strong>Приемчик:</strong>
    </div>
</div>
<br>
<div style="clear: both">
    <div style="float: left; width: 50%;">
        <strong>ЕГН:</strong>
    </div>
    <div style="float: left; width: 50%;">
        <strong>Печат:</strong>
    </div>
</div>