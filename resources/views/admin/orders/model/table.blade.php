<tr data-id="{{ $order->id }}">
    <td>{{ $order->user->name }}</td> 
    <td>{{ $order->user->email }}</td> 
    <td>{{ $order->user->phone }}</td> 
    <td>{{ $order->user->city }}</td> 
    <td>{{ $order->model->name }}</td> 
    <td>@if($order->status == 'pending') 
            <span class="badge bgc-deep-purple-50 c-deep-purple-700 p-10 lh-0 tt-c badge-pill">Очаква одобрение</span> 
        @elseif($order->status == 'accepted') 
            <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Приет/В процес</span> 
        @elseif($order->status == 'ready') 
            <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Върнат от работилница</span> 
        @else 
            <span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">Получен</span>  @endif</td> 
    <td><span data-url="orders/model/{{$order->id}}" class="edit-btn" data-toggle="modal" data-target="#editOrder" data-form-type="edit" data-form="modelOrders"><i class="c-brown-500 ti-pencil"></i></span>
        {{-- <span data-url="jewels/delete/{{$jewel->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> --}}
    </td>
</tr>