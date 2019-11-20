<h1 style="text-align: center;">Магазин за златна и сребърна бижутерия</h1>
<h2 style="text-align: center;">{{ $store->name }} - {{ $store->location }}</h2>
<h2 style="text-align: center;">тел.: {{ $store->phone }}</h2>
<hr/>

<h1 style="text-align: center;"><strong>ПОРЪЧКА №: {{ $order->id }}</strong></h1>
<h2 style="text-align: center;">бижутерско изделие</h2>

<div>
    <strong>Клиент: </strong> {{ $user->first_name }} {{ $user->last_name }}
</div>
<hr/>

<div>
    <strong>Тел: </strong> {{ $user->phone }}
</div>
<hr/>

<div>
    <strong>Опис: </strong> {{ $order->content }}
</div>
<hr/>

<div>
    <strong>Материал: </strong> {{ $material->name }} - {{ $material->code }} - {{ $material->color }}
</div>
<hr/>

@if (Illuminate\Support\Str::lower($material->name) == "злато")
    <div>
        <strong>Карат: </strong> {{ $material->carat }} <strong>Грам: </strong> {{ $order->weight }}
    </div>
@else
    <div>
        <strong>Грам: </strong> {{ $order->gross_weight }}
    </div>

@endif
<hr/>

<div>
    <strong>Дата на приемане: </strong> {{ $order->created_at }}
</div>
<hr/>

<div>
    <strong>Прог.цена: </strong> {{ $order->price }}лв.
    <strong>Капаро: </strong> {{ $order->earnest }}лв.
    <strong>Остатък: </strong> {{ $order->price - $order->earnest }}лв.
</div>
<hr/>

<div>
    <strong>Клиент: </strong>
    <strong style="margin-left: 200px;">Приемчик: </strong>
</div>
<hr/>
