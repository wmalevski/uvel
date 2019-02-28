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
        <!-- @foreach($payment->discounts as $discount)
            @if($discount->discount)
                {{ $discount->discount }}%
            @else
                {{ $discount->discount }}%
            @endif
            {{ $discount->discount->discount }}% 
        @endforeach -->
        <br/> 
        Виж артикули <br/>
        @foreach($payment->sellings as $selling)
            @if($selling->product_id != '')
                {{ $selling->product->name }}
            @elseif($selling->repair_id != '')
                {{ $selling->product->name }}
            @elseif($selling->product_other_id != '')
                {{ $selling->product->customer_name }}
            @endif
        @endforeach
        <br/>Допълнителна информация {{ $payment->info }}</td>
</tr>
