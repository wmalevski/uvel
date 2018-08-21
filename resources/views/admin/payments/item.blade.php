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
    <td>Виж отстъпки <br/> Виж артикули {{ $payment->sellings }} <br/> Допълнителна информация</td>
</tr>