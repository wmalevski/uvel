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
    <td>
        @if($selling->status == 'waiting_user')
            Очаква изпращане/вземане
        @elseif($selling->status == 'done')
            Приключена
        @endif
    </td>
    <td><span data-url="selling/online/{{$selling->id}}" class="edit-btn" data-form-type="edit" data-form="payments" data-toggle="modal" data-target="#editPayment"><i class="c-brown-500 ti-pencil"></i></span></td> 
</tr>