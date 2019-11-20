<h2 style="text-align: center;">Магазин за златна и сребърна бижутерия</h2>
<h2 style="text-align: center;">{{ $store->name }} - {{ $store->location }}</h2>
<h2 style="text-align: center;">тел.: {{ $store->phone }}</h2>
<hr/>

<h1 style="text-align: center;"><strong>РЕМОНТ №: {{ $repair->id }}</strong></h1>
<h2 style="text-align: center;">бижутерско изделие</h2>

<div>
    <strong>Клиент: </strong> {{ $repair->customer_name }}
</div>
<hr/>

<div>
    <strong>Тел: </strong> {{ $repair->customer_phone }}
</div>
<hr/>

<div>
    <strong>Опис: </strong> {{ $repair->repair_description }}
</div>
<hr/>

<div>
    <strong>Дата на приемане: </strong> {{ $repair->created_at }}
</div>
<hr/>

<div>
    <strong>Прог.цена: </strong> {{ $repair->price }}лв.
    <strong>Капаро: </strong> {{ $repair->deposit }}лв.
    <strong>Остатък: </strong> {{ $repair->price - $repair->deposit }}лв.
</div>
<hr/>
<div>
    <strong>Материал: </strong> {{ $material->name }} - {{ $material->code }} - {{ $material->color }}
</div>
<div>
    <strong>Бижу на клиента: </strong>
    @if (Illuminate\Support\Str::lower($material->name) == "злато")
        Карат: {{ $material->carat }}
    @endif
    Грам: {{ $repair->weight }}
</div>
<div>
    <strong>Клиент: </strong>
    <strong style="margin-left: 200px;">Приемчик: </strong>
</div>
<hr/>

<div>
    <strong>Дата за получаване: </strong> {{ $repair->date_returned }}
</div>

