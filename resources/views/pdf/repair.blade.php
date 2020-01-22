<h3 style="margin: 5px 0; text-align: center;">Магазин за златна и сребърна бижутерия</h3>
<h3 style="margin: 5px 0; text-align: center;">{{ $store->name }} - {{ $store->location }}</h3>
<h4 style="margin: 5px 0; text-align: center;">тел.: {{ $store->phone }}</h4>

<hr/>

<h2 style="margin: 10px 0; text-align: center;"><strong>РЕМОНТ №: {{ $repair->id }}</strong></h2>
<h3 style="margin: 5px 0 20px; text-align: center;">бижутерско изделие</h3>

<div>
    <strong>Клиент: </strong> {{ $repair->customer_name }}
</div>
<hr/>

<div>
    <strong>Тел: </strong> {{ $repair->customer_phone }}
</div>
<hr/>

<div style="height: 100px">
    <strong>Опис: </strong> {{ $repair->repair_description }}
</div>
<hr/>

<div>
    <strong>Дата на приемане: </strong> {{ date("d-m-Y",strtotime($repair->created_at)) }}
</div>
<hr/>

<div style="clear: both;">
    <div style="float: left; width: 33.33%;">
        <strong>Цена: </strong> {{ $repair->price }}лв. <br>
    </div>
    <div style="float: left; width: 33.33%;">
        <strong>Капаро: </strong> {{ $repair->deposit }}лв. <br>
    </div>
    <div style="float: left; width: 33.33%;">
        <strong>Остатък: </strong> {{ $repair->price - $repair->deposit }}лв.<br>
    </div>
</div>
<hr/>
<div>
    <strong>Бижу на клиента: </strong>
    {{ $material->name }} - {{ $material->code }} - {{ $material->color }},
    @if (Illuminate\Support\Str::lower($material->name) == "злато")
       {{ $material->carat }} кт.,
    @endif
    {{ $repair->weight }} гр.
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
        <strong>Дата за получаване: </strong> {{ $repair->date_returned }}
    </div>

    <div style="float: left; width: 30%;">
        {!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($repair->barcode, "EAN13",1,33,"black", true)) !!}
    </div>
</div>

