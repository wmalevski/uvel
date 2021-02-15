<tr data-id="{{ $order->id }}">
    <td>
      <img class="admin-product-image" src="{{ asset("uploads/models/" . $order->photos->first()['photo']) }}">
    </td>
    <td>{{ $order->id }}</td>
    <td>{{ $order->deadline ? $order->deadline->format('d/m/Y') : ''}}</td>
    <td>{{ $order->model->name }}</td>
    <td>{{ $order->model_size }}</td>
    <td>{{ $order->user_payment->user->email }}</td>
    <td>{{ $order->user_payment->phone }}</td>
    <td>{{ $order->user_payment->city }}</td>
    <td>@switch($order->model_status)
        @case('pending')
            <span class="badge bgc-deep-purple-50 c-deep-purple-700 p-10 lh-0 tt-c badge-pill">Очаква одобрение</span>
            @break;
        @case('accepted')
            <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Приет/В процес</span>
            @break;
        @case('ready')
            <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Върнат от работилница</span>
            @break;
        @default
            <span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">Получен</span>
            @break;
    @endswitch</td>

    @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
        <td align="center">
            <span data-url="orders/model/{{$order->id}}" class="edit-btn" data-toggle="modal" data-target="#editOrder" data-form-type="edit" data-form="modelOrders"><i class="c-brown-500 ti-pencil"></i></span>
            <a data-print-label="true" target="_blank" href="{{ route('order_model_receipt', $order->id) }}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a>
        </td>
    @endif
</tr>