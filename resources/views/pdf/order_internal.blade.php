<div style="text-align: center;">
    <div id="orderDetails" style="width:100%;font-size:0;line-height:20px;">
        <div style="width:50%;margin:0;padding:0;text-align:left;float:left;"><h4>ПОРЪЧКА №: <b>{{$order->id}}</b></h4></div>
        <div style="width:50%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">За магазин: <b>{{$store->name}} {{$store->location}}</b></div>
        <div style="width:50%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">Получена: <b>{{$order->date_received}}</b></div>
        <div style="width:50%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">Изпълнение До: <b>{{$order->date_returned}}</b></div>
        <div style="width:50%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">Клиент: <b>{{$order->customer_name}}</b></div>
        <div style="width:50%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">Телефон: <b>{{$order->customer_phone}}</b></div>
        <div style="width:100%;margin:0;padding:0;font-size:10px;text-align:right;float:left;">Цена: <b>{{$order->price}}</b> лв.</div>
        <br>
        <br>
        @if($model->name && $jewel->name)
        <div style="width:50%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">Модел: <b>{{$model->name}}</b></div>
        <div style="width:50%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">Вид: <b>{{$jewel->name}}</b></div>
        @endif

        <div style="width:50%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">Материал: <b>{{$material->name}} {{$material->code}}, {{$material->color}}</b></div>
        <div style="width:50%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">Грамаж: <b>
        @if (Illuminate\Support\Str::lower($material->name) == "злато")
            {{$order->weight}}
        @else
            {{$order->gross_weight}}
        @endif
        </b>гр.</div>
        <div style="width:50%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">Размер: <b>{{$order->size}}</b></div>
        <div style="width:50%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">Брой: <b>{{$order->quantity}}</b></div>

        @if($orderStones)
        <div style="width:100%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">Камъни:
        @foreach($orderStones as $stone)
            <br>◉ <b>{{$stone}}</b>
        @endforeach
        </div>@endif
        <br style="clear:both;">

        <div style="width:100%;margin:0;padding:0;font-size:10px;text-align:center;"><img class="admin-product-image" src="{{ $orderImage }}" style="max-height:200px;"/></div>

        <br>
        <div style="width:100%;margin:0;padding:0;font-size:10px;text-align:left;float:left;">Описание: {!! $order->notes?:'<i>Няма</i>' !!}</div>
    </div>
</div>