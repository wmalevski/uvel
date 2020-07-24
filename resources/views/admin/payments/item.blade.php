<tr data-id="{{ $payment->id }}">
    <td>{{ $payment->user->getStore()->id }}</td>
    <td>{{ $payment->created_at }}</td> 
    <td>{{ $payment->price }}</td> 
    <td>
        @if($payment->method == 'cash')
            Кеш
        @elseif($payment->method == 'post')
            Пос терминал
        @endif
    </td>

    <td>
        @if($payment->receipt == 'yes')
            С фискален бон
        @else 
            Без фискален бон
        @endif
    </td>
    <td>{{ $payment->user->email }}</td>
    <td>
        @if(!!count($payment->discounts))
           @foreach($payment->discounts as $discount)
                @if($discount->discount_code_id)
                    Отстъпка:  {{$discount->discount_code_id }}%
                @endif
            @endforeach
           <br/>
        @endif
        @if(isset($payment->sellings))
            @foreach($payment->sellings as $key => $selling)
                @if($selling->product_id)
                    <br/>
                    <?php $product = App\Product::where('id', $selling->product_id)->first(); ?>
                    @if($product->photos->first())
                        <img class="admin-product-image" src="{{ asset("uploads/products/" . $product->photos->first()['photo']) }}">
                    @endif
                    {{App\Model::where('id', $product->model_id)->first()->name }} - №: {{  $selling->product_id }}
                    @elseif($selling->repair_id)
                        Ремонт - {{ App\Repair::where('id', $selling->repair_id)->first()->customer_name }} - №: {{ $selling->repair_id }}
                    @elseif($selling->product_other_id)
                        <br/>
                        <?php $productOther = App\ProductOther::where('id', $selling->product_other_id)->first(); ?>
                        @if($productOther->photos->first())
                            <img class="admin-product-image" src="{{ asset("uploads/products_others/" . $productOther->photos->first()['photo']) }}">
                        @endif
                        {{$productOther->name }} - №: {{ $selling->product_other_id }}
                    @elseif($selling->order_id)
                        Поръчка - №: {{$selling->order_id}} - {{App\Order::where(['id' => $selling->order_id])->first()->customer_name}}
                @endif
                @if(1 + $key < count($payment->sellings)) , @endif
            @endforeach
        @endif
        @if(isset($payment->info))
        <br/>Допълнителна информация: {{ $payment->info }}
        @endif
    </td>
    <td>
        @if($payment->sellings->isEmpty() === true && $payment->exchange_materials->isEmpty() === false )
            Разсписка (Обмяна): <a data-print-label="true" target="_blank" href="/ajax/generate/exchangeacquittance/{{$payment->id}}" class="print-btn">
                <i class="c-brown-500 ti-printer"></i>
            </a>
        @elseif($payment->sellings->isEmpty() === false)
            @foreach($payment->sellings as $selling)
                @if($selling->product_id)
                    @if(App\Product::where('id', $selling->product_id)->first())
                        Сертификат ({{$product = App\Product::where('id', $selling->product_id)->first()->name}} - №: {{  $selling->product_id }}):
                    @endif
                    <a data-print-label="true" target="_blank" href="{{route('selling_certificate', ['id' => $selling->product_id, 'orderId' => null])}}" class="print-btn">
                        <i class="c-brown-500 ti-printer"></i>
                    </a><br>

                    @if(App\Product::where('id', $selling->product_id)->first())
                    Разсписка ({{$product = App\Product::where('id', $selling->product_id)->first()->name}} - №: {{  $selling->product_id }}):
                    @endif
                    <a data-print-label="true" target="_blank" href="{{route('selling_receipt', ['id' => $selling->product_id, 'type' => 'product', 'orderId' => null])}}" class="print-btn">
                        <i class="c-brown-500 ti-printer"></i>
                    </a><br>
                @elseif($selling->order_id)
                    @if(App\Order::where(['id' => $selling->order_id])->first()->product_id)
                       <?php $id = App\Order::where(['id' => $selling->order_id])->first()->product_id; ?>
                    @elseif(!App\Order::where(['id' => $selling->order_id])->first()->product_id)
                        <?php $id = App\Order::where(['id' => $selling->order_id])->first()->model_id; ?>
                    @elseif(!App\Order::where(['id' => $selling->order_id])->first()->product_other_id)
                        <?php $id = App\Order::where(['id' => $selling->order_id])->first()->product_other_id; ?>
                    @endif

                    @if(App\Product::where('id', $id)->first())
                        Сертификат ({{$product = App\Product::where('id', $id)->first()->name}} - №: {{  $id }}):
                    @endif
                    <a data-print-label="true" target="_blank" href="{{route('selling_certificate', [$id, $selling->order_id])}}" class="print-btn">
                        <i class="c-brown-500 ti-printer"></i>
                    </a><br>

                    @if(App\Product::where('id', $id)->first())
                        Разсписка ({{$product = App\Product::where('id', $id)->first()->name}} - №: {{  $id }}):
                    @endif
                    <a data-print-label="true" target="_blank" href="{{route('order_receipt',[$id])}}" class="print-btn">
                        <i class="c-brown-500 ti-printer"></i>
                    </a><br>
                @elseif($selling->product_other_id)
                    @if($product = App\ProductOther::where('id', $selling->product_other_id)->first())
                        Разсписка ({{$product = App\ProductOther::where('id', $selling->product_other_id)->first()->name}} - №: {{  $selling->product_other_id }}):
                    @endif
                    <a data-print-label="true" target="_blank" href="{{route('selling_receipt', ['id' => $selling->product_other_id, 'type' => 'box', 'orderId' => null])}}" class="print-btn">
                        <i class="c-brown-500 ti-printer"></i>
                    </a><br>
                @elseif($selling->repair_id)
                    Разсписка (Ремонт - №: {{  $selling->repair_id }}):
                    <a data-print-label="true" target="_blank" href="{{route('repair_receipt', ['id' => $selling->repair_id])}}" class="print-btn">
                        <i class="c-brown-500 ti-printer"></i>
                    </a><br>
                @endif
            @endforeach
        @endif
    </td>
</tr>