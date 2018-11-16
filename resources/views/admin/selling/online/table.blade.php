<tr data-id="{{ $selling->id }}">
    {{-- <td>{{ $payment->user->getStore()->name }}</td>  --}}
    <td>{{ $selling->user->name }}</td> 
    <td>
            @if($selling->shipping_method == 'ekont')
                Еконт
            @elseif($selling->shipping_method == 'store') 
                Взимане от магазин
            @endif
        </td>
    <td>
        @if($selling->payment_method == 'on_delivery')
            Наложен платеж
        @elseif($selling->payment_method == 'paypal') 
            Paypal
        @endif
    </td> 
    <td>{{ $selling->price }}лв.</td> 
    <td>{{ $selling->created_at }}</td> 
    <td>Едит</td> 
</tr>