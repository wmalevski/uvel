<div class="editPaymentWrapper">
	<div class="modal-header">
		<h5 class="modal-title" id="editPaymentLabel">Информация за онлайн продажба</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<form method="POST" action="selling/online/{{ $selling->id }}" name="editPayments" data-type="edit">
		<input name="_method" type="hidden" value="PUT">
		<div class="modal-body">
			<div class="info-cont"></div>
			{{ csrf_field() }}
			<div class="form-row">
				<div class="form-group col-md-6">Име на клиент: {{ $selling->user->first_name }} {{ $selling->user->last_name }}</div>
				<div class="form-group col-md-6">Начин на плащане:
				@switch($selling->payment_method)
					@case('on_delivery')
						@if($selling->shipping_method=='store')При получаване
						@else Наложен платеж
						@endif
					@break;
					@case('paypal')Paypal@break;
				@endswitch
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">Начин на получаване:
				@switch($selling->shipping_method)
					@case('office_address')Вземане от офис на куриер@break;
					@case('store')Вземане от магазин<br>Магазин: ({{ $selling->store->name }}, {{ $selling->store->location }})@break;
					@case('home_address')Доставка до адрес@break;
				@endswitch
				</div>
				@if($selling->shipping_method=='store')
				<div class="form-group col-md-6">Телефон: {{ $selling->user->phone }}<br>Град: {{ $selling->user->city }}</div>
				@else
				<div class="form-group col-md-6">Телефон: {{ $selling->phone }}</div>
				@endif
			</div>

			@if (in_array($selling->shipping_method,array('home_address','office_address')))
			<div class="form-row">
				<div class="form-group col-md-6"></div>
				<div class="form-group col-md-6">Адрес за доставка: {{$selling->shipping_address}}</div>
			</div>
			@endif

			<div class="form-row">
				<div class="form-group col-md-12">Допълнителна информация:</div>
				<div class="form-group col-md-12">
					@if($orderInfo)
					<textarea class="orderInfo" readonly>{{$orderInfo}}</textarea>
					@else <i>Няма</i>
					@endif
				</div>
			</div>

			@if(!empty($discount_codes))
			<hr>
			<div class="form-row">
				<div class="form-group col-md-12"><b>Отстъпки</b></div>
				@foreach($discount_codes as $barcode=>$value)
				<div class="form-group col-md-6">Код: <b>{{$barcode}}</b></div>
				<div class="form-group col-md-6">Отстъпка: <b>-{{$value}}%</b></div>
				@endforeach
			</div>
			@endif

			<div class="form-row">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Продукт</th>
							<th scope="col">Брой</th>
							<th scope="col">Тегло</th>
							<th scope="col">Цена</th>
						</tr>
					</thead>
					<tbody>
						@foreach($products as $product)
						<tr>
							<td scope="row">
							@if($product->product_id)
								<div class="sell-product-thumbnail">
									<img class="admin-product-image" rel="product" src="{{ asset("uploads/products/".App\Gallery::where(array('table'=>'products', 'product_id'=>$product->product_id ))->first()['photo']) }}" name="{{ $product->product_id }}"/>
								</div>
								&numero; {{ $product->product_id }}
							@elseif($product->product_other_id)
								<div class="sell-product-thumbnail">
									<img class="admin-product-image" rel="product_other" src="{{ asset("uploads/products_others/".App\Gallery::where(array('table'=>'products_others', 'product_other_id'=>$product->product_other_id))->first()['photo']) }}" />
								</div>
								&numero; {{$product->product_other_id}}
							@elseif($product->model_id)
								<div class="sell-product-thumbnail">
									<img class="admin-product-image" rel="model" src="{{ asset("uploads/models/".App\Gallery::where(array('table'=>'models', 'model_id'=>$product->model_id))->first()['photo']) }}" />
								</div>
								По Модел: {{ App\Model::where(array("id"=>$product->model_id))->first()->name }}<br>
								Размер: {{ App\Selling::where(array('payment_id'=>$selling->id,'model_id'=>$product->model_id))->first()->model_size }}
							@endif
							</td>
							<td>{{ $product->quantity }}</td>
							<td>{{ $product->weight }} гр.</td>
							<td>{{ $product->price }} лв.</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
			@if($selling->status !== 'done')
				<button type="submit" id="edit" class="edit-btn-modal btn btn-primary">Приключи</button>
			@endif
		</div>
	</form>
</div>
<style>
	textarea.orderInfo{
		width: 100%;
	    height: 30px;
	    background: silver;
	    border: none;
	    padding: 5px;
	    box-sizing: border-box;
	    cursor:default;
	    -moz-box-shadow: inset 0 0 10px #8c8b8b;
	    -webkit-box-shadow: inset 0 0 10px #8c8b8b;
	    box-shadow: inset 0 0 10px #8c8b8b;
	    border: 1px solid #949393;
	}
</style>