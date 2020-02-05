<tr data-id="{{ $payment->id }}">
    <td>{{ $payment->user->getStore()->name }}</td> 
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
        @if(isset($payment->discounts))
           @foreach($payment->discounts as $discount)
                @if($discount->discount_code_id)
                    Отстъпка:  {{$discount->discount_code_id }}%
                @endif
            @endforeach
           <br/>
        @endif
        Артикули: <br/>
        @if(isset($payment->sellings))
            @foreach($payment->sellings as $key => $selling)
                @if($selling->product_id)
                    {{App\Model::where('id', App\Product::where('id', $selling->product_id)->first()->model_id)->first()->name }} {{  $selling->product_id }}
                @elseif($selling->repair_id)
                   Ремонт - {{ App\Repair::where('id', $selling->repair_id)->first()->customer_name }} {{ $selling->repair_id }}
                @elseif($selling->product_other_id)
                   {{App\ProductOther::where('id', $selling->product_other_id)->first()->name }} {{ $selling->product_other_id }}
                @endif
                    @if(1 + $key < count($payment->sellings)) , @endif
            @endforeach
        @endif
        @if(isset($payment->info))
            <br/>Допълнителна информация: {{ $payment->info }}</td>
        @endif
</tr>
