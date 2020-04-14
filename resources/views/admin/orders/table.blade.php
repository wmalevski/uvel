<tr data-id="{{ $order->id }}">
 <td>{{ $order->id }}</td>
 <td>{{ $order->store_id }}</td>
  <td> 
    @if($order->model)
      {{ $order->model->name }} [{{ $order->model->id }}]
    @elseif($order->product)
      {{ $order->product->name }} [{{ $order->product->id }}]
    @endif
  </td>
  <td>
    @if($order->model)
      <img class="admin-product-image" src="{{ asset("uploads/models/" . $order->model->photos->first()['photo']) }}">
    @elseif($order->product)
      <img class="admin-product-image" src="{{ asset("uploads/products/" . $order->product->photos->first()['photo']) }}">
    @endif
  </td>
  <td> @if($order->model) {{ $order->jewel->name }} @endif </td> 
  <td> {{ $order->retailPrice->price }} </td> 
  <td> 
    @if($order->weight_without_stones == 'yes')
      {{ $order->weight }}
    @else
      {{ $order->gross_weight }}
    @endif
  </td>
  <td> {{ $order->price }} </td> 
  {{-- <td> {{ ($order->retailPrice->price)*$order->weight }} </td> --}}
  <td>@if($order->status == 'ready') <span class="badge bgc-deep-purple-50 c-deep-purple-700 p-10 lh-0 tt-c badge-pill">Обработена</span> @elseif($order->status == 'done') <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Продаден</span> @else <span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">Приет</span>  @endif</td> 
  <td>
      <span data-url="orders/{{$order->id}}" class="edit-btn" data-form-type="edit" data-form="orders" data-toggle="modal" data-target="#editOrder"><i class="c-brown-500 ti-pencil"></i></span>
      @if($order->status == 'ready')
          <a data-print-label="true" target="_blank" href="/ajax/orders/print/{{$order->id}}"
              class="print-btn"><i class="c-brown-500 ti-printer"></i></a>
      @endif
      @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
          <span data-url="orders/delete/{{$order->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
      @endif
  </td>
</tr>