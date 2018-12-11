<tr data-id="{{ $payment->id }}">
    <td>{{ $payment->id }}</td> 
    <td>{{ $payment->user->getStore()->name }}</td> 
    <td>{{ $payment->created_at }}</td> 
    <td>
        @foreach($payment->sellings as $selling)
            @if($selling->product_id != '')
                {{ $selling->product->name }}
            @elseif($selling->repair_id != '')
                {{ $selling->product->name }}
            @elseif($selling->product_other_id != '')
                {{ $selling->product->customer_name }}
            @endif
        @endforeach
    </td> 
    <td>{{ $payment->price }}</td> 
    <td> {{ $payment->fullPrice-$payment->price }}    </td>
    <td>
        @if($payment->method == 'cash')
            Кеш
        @elseif($payment->method == 'post')
            Пост терминал
        @endif
    </td>

    <td>
        @if($payment->reciept == 'yes')
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
    <td>                                                        
        Допълнителна информация {{ $payment->info }}</td>
</tr>