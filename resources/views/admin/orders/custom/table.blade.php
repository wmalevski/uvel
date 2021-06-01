@php
$prodImagePhoto=$order->photos->first();
if(isset($prodImagePhoto['photo'])){
	$productImage=$prodImagePhoto['photo'];
}
@endphp
<tr data-id="{{ $order->id }}">
	<td>{{ $order->id }}</td>
	<td>{{ $order->deadline ? $order->deadline->format('d/m/Y') : ''}}</td>
	<td>
		@if(isset($productImage))
		<img class="admin-product-image" src="{{ asset("uploads/orders/".$productImage) }}">
		@else
		<i>Няма</i>
		@endif
	</td>
	<td>{{ $order->email }}</td>
	<td>{{ $order->phone }}</td>
	<td>{{ $order->city }}</td>
	<td>@switch($order->status)
		@case('pending') <span class="badge bgc-deep-purple-50 c-deep-purple-700 p-10 lh-0 tt-c badge-pill">Очаква одобрение</span> @break;
		@case('accepted') <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Приет/В процес</span> @break;
		@case('ready') <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Върнат от работилница</span> @break;
		@default <span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">Получен</span> @break;
	@endswitch</td>
	<td>
		@if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
			<span data-url="orders/custom/{{$order->id}}" class="edit-btn" data-toggle="modal" data-target="#editOrder" data-form-type="edit" data-form="customOrders"><i class="c-brown-500 ti-pencil"></i></span>
		@endif
		<a data-print-label="true" target="_blank" href="{{ route('custom_order_model_receipt', $order->id) }}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a>
	</td>
</tr>