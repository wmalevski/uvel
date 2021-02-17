<div class="editModalWrapper">
	<div class="modal-header">
		<h5 class="modal-title" id="fullEditRepairLabel">Промени поръчка</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>

	<form method="POST" data-type="edit" name="custom_order" action="orders/custom/{{ $order->id }}">
		<input name="_method" type="hidden" value="PUT">
		<div class="modal-body">
			<div class="info-cont"></div>
			{{ csrf_field() }}

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="date_received">Приемане</label>
					<div class="input-icon form-group date-recieved">
						<div class="input-group">
							<div class="input-group-addon bgc-white bd bdwR-0"><i class="ti-calendar"></i></div>
							<input readonly type="text" value="{{ Carbon\Carbon::parse($order->created_at)->format('H:i d/m/Y')}}" class="form-control bdc-grey-200 not-clear" name="date_received" placeholder="Дата на приемане" >
						</div>
					</div>
				</div>
				<div class="form-group col-md-6">
					<label for="deadline">Срок</label>
					<div class="timepicker-input input-icon form-group deadline">
						<div class="input-group">
							<div class="input-group-addon bgc-white bd bdwR-0"><i class="ti-calendar"></i></div>
							<input type="text" data-date-autoclose="true" data-date-format="dd/mm/yyyy" name="deadline" class="form-control bdc-grey-20$ data-date-start-date="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d/m/Y')}}" data-provide="datepicker" value="{{ $order->deadline ? $order->deadline->format('d/m/Y') : '' }}" />
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="2">Име на клиент: </label>
				<input type="email" class="form-control" value="{{ $order->name }}" id="2" name="name" placeholder="Name:">
			</div>

			<div class="form-group">
				<label for="2">Email на клиент: </label>
				<input type="email" class="form-control" value="{{ $order->email }}" id="2" name="email" placeholder="Email:">
			</div>

			<div class="form-group">
				<label for="3">Телефон на клиент: </label>
				<input type="tel" class="form-control" value="{{ $order->phone }}" id="3" name="phone" placeholder="Телефон:">
			</div>

			<div class="form-group">
				<label for="4">Град на клиент: </label>
				<input type="text" class="form-control" value="{{ $order->city }}" id="4" name="city" placeholder="Град:">
			</div>

			<div class="form-group">
				<label for="4">Описание на поръчката: </label>
				<textarea class="form-control" name="content">{{ $order->content }}</textarea>
			</div>

			<div class="form-group">
				<label for="offer">Оферта: </label>
				<textarea class="form-control" name="offer">{{ $order->offer }}</textarea>
			</div>
			<div class="form-group">
				<label for="ready_product">Данни за готово изделие: </label>
				<textarea class="form-control" name="ready_product">{{ $order->ready_product }}</textarea>
			</div>

			<div class="form-row">
				<div class="form-group col-md-5">
					<div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
						@if($order->status == 'pending')
							<input type="checkbox" id="pending" name="status_accept" class="peer">
							<label for="pending" class="peers peer-greed js-sb ai-c">
								<span class="peer peer-greed">Приемане</span>
							</label>
						@elseif($order->status == 'accepted')
							<input type="checkbox" id="accepted" name="status_ready" class="peer">
							<label for="accepted" class="peers peer-greed js-sb ai-c">
								<span class="peer peer-greed">Готов за предаване</span>
							</label>
						@elseif($order->status == 'ready')
							<input type="checkbox" id="ready" name="status_delivered" class="peer" value="delivered">
							<label for="ready" class="peers peer-greed js-sb ai-c">
								<span class="peer peer-greed">Получен</span>
							</label>
						@else
							Поръчката е успешно предадена и приета от клиента.
						@endif
					</div>
				</div>
			</div>

			<div class="uploaded-images-area">
				@foreach($basephotos as $photo)
					<div class='image-wrapper'>
						<img src="{{$photo['photo']}}" alt="" class="img-responsive" />
					</div>
				@endforeach
			</div>

		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
			<button type="submit" id="edit" data-state="edit_order" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
		</div>
	</form>
	</div>