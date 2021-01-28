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
					@case('on_delivery')Наложен платеж@break;
					@case('paypal')Paypal@break;
				@endswitch
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">Начин на получаване:
				@switch($selling->shipping_method)
					@case('office_address')Вземане от офис на куриер@break;
					@case('store')Вземане от магазин ({{ $selling->store->name }})@break;
					@case('home_address')Доставка до адрес@break;
				@endswitch
				</div>
				<div class="form-group col-md-6">Телефон: {{ $selling->phone }}</div>
			</div>

			@if (in_array($selling->shipping_method,array('home_address','office_address')))
			<div class="form-row">
				<div class="form-group col-md-6"></div>
				<div class="form-group col-md-6">Адрес за доставка: {{$selling->shipping_address}}</div>
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
							<th scope="row">
								@if($product->product_id)
								&numero; {{ $product->product_id }}
								@elseif($product->product_other_id)
								&numero; {{$product->product_other_id}}
								@elseif($product->model_id)
								По Модел: {{ App\Model::where(array("id"=>$product->model_id))->first()->name }}
							@endif
							</th>
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