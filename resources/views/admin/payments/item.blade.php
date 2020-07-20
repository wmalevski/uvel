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

    <td>
        @if($payment->ticket == 'yes')
            С разписка
        @else 
            Без разписка
        @endif
    </td>

    <td>
        @if($payment->certificate == 'yes')
            Със сертификат
        @else 
            Без сертификат
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
        Артикули: Име [id]<br/>
        @if(isset($payment->sellings))
            @foreach($payment->sellings as $key => $selling)
                @if($selling->product_id)
                    <?php $product = App\Product::where('id', $selling->product_id)->first(); ?>
                    <img class="admin-product-image" src="{{ asset("uploads/products/" . $product->photos->first()['photo']) }}">
                    {{App\Model::where('id', $product->model_id)->first()->name }} [{{  $selling->product_id }}]
                @elseif($selling->repair_id)
                   Ремонт - {{ App\Repair::where('id', $selling->repair_id)->first()->customer_name }} [{{ $selling->repair_id }}]
                @elseif($selling->product_other_id)
                    <?php $productOther = App\ProductOther::where('id', $selling->product_other_id)->first(); ?>
                    <img class="admin-product-image" src="{{ asset("uploads/products_others/" . $productOther->photos->first()['photo']) }}">
                   {{$productOther->name }} [{{ $selling->product_other_id }}]
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
            <a data-print-label="true" target="_blank" href="/ajax/generate/exchangeacquittance/{{$payment->id}}" class="print-btn">
                <i class="c-brown-500 ti-printer"></i>
            </a>
        @endif
    </td>
</tr>