<tr data-id="{{ $order->id }}">
 <td>{{ $order->id }}</td>
    <td> @if($order->model) {{ $order->model->name }} @endif
        @if($order->product) {{ $order->product->name }} @endif
    </td>
    <td> @if($order->model) {{ $order->jewel->name }} @endif </td> 
    <td> {{ $order->retailPrice->price }} </td> 
    <td> {{ $order->weight }} </td>
    <td> {{ $order->price }} </td> 
    {{-- <td> {{ ($order->retailPrice->price)*$order->weight }} </td> --}}
    <td>@if($order->status == 'ready') <span class="badge bgc-deep-purple-50 c-deep-purple-700 p-10 lh-0 tt-c badge-pill">Обработена</span> @elseif($order->status == 'done') <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Продаден</span> @else <span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">Приет</span>  @endif</td> 
    <td>
        {{-- @can('edit-orders') --}}
            <span data-url="orders/{{$order->id}}" class="edit-btn" data-form-type="edit" data-form="orders" data-toggle="modal" data-target="#editOrder"><i class="c-brown-500 ti-pencil"></i></span> 
        {{-- @endcan --}}
        <a href="orders/print/{{$order->id}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a> 
        {{-- @can('delete-orders') --}}
            <span data-url="orders/delete/{{$order->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> 
        {{-- @endcan --}}
    </td>
</tr>