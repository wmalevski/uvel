<tr data-id="{{ $order->id }}">
    <td>{{ $order->name }}</td> 
    <td>{{ $order->email }}</td> 
    <td>{{ $order->phone }}</td> 
    <td>{{ $order->city }}</td> 
    <td><span data-url="orders/{{$order->id}}" class="edit-btn" data-toggle="modal" data-target="#editOrder" data-form-type="edit" data-form="orders"><i class="c-brown-500 ti-pencil"></i></span>
        {{-- <span data-url="jewels/delete/{{$jewel->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> --}}
    </td>
</tr>