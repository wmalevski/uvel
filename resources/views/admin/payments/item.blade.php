<tr data-id="{{ $payment->id }}">
    <td>{{ $payment->user->getStore()->name }}</td> 
    <td>{{ $payment->created_at }}</td> 
    <td>{{ $payment->price }}</td> 
    <td>
        @if($payment->method == 'cash')
            Кеш
        @elseif($payment->method == 'post')
            Пост терминал
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

    <td>{{ $payment->user->name }}</td>
    <td>Виж отстъпки
        @if(isset($payment->discounts))
           @foreach($payment->discounts as $discount)
                @if($discount->discount_code_id)
                    {{$discount->discount_code_id }}%
                @endif
            @endforeach
        @endif
        <br/>
        Виж артикули <br/>
        @if(isset($payment->sellings))
            @foreach($payment->sellings as $selling)
                @if($selling->product_id)
                    {{App\Model::where('id', App\Product::where('id', $selling->product_id)->first()->model_id)->first()->name }} {{  $selling->product_id }}
                @elseif($selling->repair_id)
                   Ремонт - {{ App\Repair::where('id', $selling->repair_id)->first()->customer_name }} {{ $selling->repair_id }}
                @elseif($selling->product_other_id)
                   {{App\ProductOther::where('id', $selling->product_other_id)->first()->name }} {{ $selling->product_other_id }}
                @endif
            @endforeach
        @endif
        <br/>Допълнителна информация {{ $payment->info }}</td>
</tr>
