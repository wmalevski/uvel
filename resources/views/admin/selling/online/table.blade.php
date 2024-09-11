<tr data-id="{{ $selling->id }}">
	<td style="padding-right: 0;">
		<span class="sell-status
			@switch($selling->status)
				@case('waiting_user')sell-status--pending @break;
				@case('waiting_staff')sell-status--pendingStaff @break;
				@case('done')sell-status--done @break;
			@endswitch"></span>
	</td>
	<td>{{ $selling->payment->user->email }}</td>
	<td>
	@switch($selling->shipping_method)
		@case('office_address') От куриер @break;
		@case('store') От магазин @break;
		@case('home_address') До адрес @break;
	@endswitch
	</td>
	<td>
	@switch($selling->payment_method)
		@case('on_delivery')Нл. платеж@break;
		@case('paypal')Paypal@breal;
	@endswitch
	</td>
	<td>{{ $selling->price }}лв.</td>
	<td>{{ date_format($selling->created_at,"d-m-Y") }}</td>
	<td class="sell-products">
	@foreach(App\UserPaymentProduct::where('payment_id', $selling->id)->get() as $product)
		<div class="sell-product-thumbnail">
		@if($product->product_id)
			<img class="admin-product-image" rel="product" src="{{ asset("uploads/products/".App\Gallery::where(array(
				'table'=>'products',
				'product_id'=>$product->product_id
			))->first()['photo']) }}" name="{{ $product->product_id }}"/>
			<span>x {{ $product->quantity }}</span>
		@elseif($product->product_other_id)
			<img class="admin-product-image" rel="product_other" src="{{ asset("uploads/products_others/".App\Gallery::where(array(
				'table'=>'products_others',
				'product_other_id'=>$product->product_other_id
			))->first()['photo']) }}" />
		@elseif($product->model_id)
			<img class="admin-product-image" rel="model" src="{{ asset("uploads/models/".App\Gallery::where(array(
				'table'=>'models',
				'model_id'=>$product->model_id
			))->first()['photo']) }}" />
		@endif
		</div>
	@endforeach
	</td>
	@if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'manager', 'cashier']))
	 <td><span data-url="selling/online/{{$selling->id}}" class="edit-btn" data-form-type="edit" data-form="editPayments" data-toggle="modal" data-target="#editPayment"><i class="c-brown-500 ti-pencil"></i></span></td>
	@endif
</tr>
<style type="text/css">
	.modal-dialog{max-width: 80%;}
</style>