@extends('admin.layout')
@php
$givenMaterialRowTpl = '<div class="form-row">
						<div class="form-group col-md-6"> 
							<label for="">Вид</label>
							<select name="given_material_id[]" data-calculateprice-material class="material_type form-control calculate" data-search="/ajax/select_materials/">
								<option value="">Избери</option>';
								
							$givenMaterialRowTpl .= '</select>
						</div>
						<div class="form-group col-md-5">
							<label for="grossWeight">Количество:</label>
							
							<div class="input-group">
								<input type="number" class="form-control mat-quantity" name="mat_quantity[]" placeHolder="0" step="0.01">
							</div>
						</div>
						<div class="form-group col-md-1">
							<span class="delete-material remove_field" data-materials-remove><i class="c-brown-500 ti-trash"></i></span>
						</div>
					</div>';

$givenMaterialRowTpl = str_replace("\n", "", str_replace("\r", "", $givenMaterialRowTpl));
$newStoneRow =
				'<div class="form-group col-md-6"><label>Камък:</label>
                    <select name="stones[]" class="form-control" data-calculatePrice-stone data-search="/ajax/select_search/stones/">
                        <option value="">Избери</option>';
                        $newStoneRow .= '</select>
                </div>
				<div class="form-group col-md-4">
					<label>Брой:</label>
					<input type="text" value="" class="form-control calculate-stones" name="stone_amount[]" data-calculateStones-amount placeholder="Брой">
				</div>
				<div class="form-group col-md-2">
					<span class="delete-stone remove_field" data-stone-remove><i class="c-brown-500 ti-trash"></i></span>
				</div>
				<div class="form-group col-md-6">
					<div class="form-group">
						<label>Тегло: </label>
						<div class="input-group">
							<input type="number" value="" class="form-control calculate-stones" name="stone_weight[]" data-calculateStones-weight placeholder="Тегло:" min="0.1" max="100" disabled>
							<span class="input-group-addon">гр.</span>
						</div>
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 stone-flow-holder">
						<input type="checkbox" id="" class="stone-flow calculate-stones" name="stone_flow[]" class="peer">
						<label for="" class="peers peer-greed js-sb ai-c">
							<span class="peer peer-greed">За леене</span>
						</label>
						<span class="row-total-weight"></span>
					</div>
				</div>';

$newStoneRow = str_replace("\n", "", str_replace("\r", "", $newStoneRow));
@endphp

@section('content')
<div class="modal fade" id="addOrder" role="dialog" aria-labelledby="addOrderlLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addOrderLabel">Направи поръчка</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" name="orders" data-type="add" action="orders" autocomplete="off">
				<div class="modal-body">
					<div class="info-cont"></div>
					{{ csrf_field() }}
					
					<div class="form-row">
						<div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
							<input type="checkbox" id="weightWithStones" name="with_stones" class="peer" data-calculatePrice-withStones>
							<label for="weightWithStones" class="peers peer-greed js-sb ai-c">
								<span class="peer peer-greed">Тегло с камъни</span>
							</label>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="weight">Сканирай продукт:</label>
							
							<div class="input-group">
								<input type="text" data-url="ajax/orders/getProductInfo/" class="form-control" id="calculate_product" 
											 name="product_id" placeholder="Сканирай продукт:">
							</div>
						</div>
						
						<div class="col-12">
							<hr>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputEmail4">Име</label>
							<input type="text" class="form-control" name="customer_name" placeholder="Име на клиент">
						</div>
						<div class="form-group col-md-6">
							<label for="inputPassword4">Телефон</label>
							<input type="text" class="form-control" name="customer_phone" placeholder="Телефон на клиента">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputCity">Приемане</label>
							<div class="input-icon form-group date-recieved">
								<div class="input-group">
									<div class="input-group-addon bgc-white bd bdwR-0">
										<i class="ti-calendar"></i>
									</div>
									<input readonly type="text" value="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" class="form-control bdc-grey-200 not-clear" name="date_received" placeholder="Дата на приемане">
								</div>
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="inputZip">Срок</label>
							<div class="timepicker-input input-icon form-group date-returned">
								<div class="input-group">
									<div class="input-group-addon bgc-white bd bdwR-0">
										<i class="ti-calendar"></i>
									</div>
									<input type="text" data-date-autoclose="true" data-date-format="dd-mm-yyyy" name="date_returned" class="form-control bdc-grey-200 start-date" value="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" placeholder="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" data-date-start-date="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" data-provide="datepicker">
								</div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Модел:</label>
							
							<select data-url="ajax/orders/getModelInfo/" name="model_id" class="model-select form-control model-filled" data-calculatePrice-model data-search="/ajax/select_search/models/">
								<option value="">Избери</option>
							</select>
						</div>
						
						<div class="form-group col-md-6">
							<label>Вид:</label>
							
							<select name="jewel_id" class="jewels_types form-control" data-modelFilled-jewel disabled data-search="/ajax/select_search/jewels/">
								<option value="">Избери</option>
							</select>
						</div>
						
						<div class="col-12">
							<hr>
						</div>
					</div>

					<div class="form-row model_materials">
						<div class="form-group col-md-12">
							<label>Материал:</label>
							
							<select name="material_id" class="material_type form-control material calculate" data-calculatePrice-material disabled data-search="/ajax/select_search/global/materials/">
								<option value="">Избери</option>
							</select>
						</div>

						<div class="form-group col-md-6">
							<label>Цена:</label>
							
							<select name="retail_price_id" class="form-control calculate prices-filled retail-price retail_prices" data-calculatePrice-retail disabled>
								<option value="0">Избери</option>
							</select>
						</div>
						<div class="form-group col-md-3 weight-holder">
							<label for="weight">Нетно тегло:</label>
							
							<div class="input-group">
								<input type="text" class="form-control weight calculate" id="weight" name="weight" data-calculatePrice-netWeight placeholder="Тегло:" min="1" max="10000">
								<span class="input-group-addon">гр.</span>
							</div>
						</div>

						<div class="form-group col-md-3">
							<label for="size">Размер:</label>
							
							<input type="text" class="form-control size" id="size" name="size" placeholder="Размер:" min="1" data-modelFilld-size max="10000">
						</div>
						
						<div class="col-12">
							<hr>
						</div>
					</div>

					<div class="model_stones"></div>

					<div class="form-row">
						<div class="form-group col-md-6 mt-auto">
							<button type="button" class="btn btn-primary add_field_button" data-addStone-add>
								Добави камък
							</button>
						</div>

						<div class="form-group col-md-6">
							<label for="totalStones">Общо за леене:</label>
							
							<div class="input-group">
								<input type="text" class="form-control" id="totalStones" name="totalStones" data-calculateStones-total disabled>
								<span class="input-group-addon">гр.</span>
							</div>
						</div>

						<div class="col-12">
							<hr>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="grossWeight">Брутно тегло:</label>
							
							<div class="input-group">
								<input type="number" class="form-control" name="gross_weight" id="grossWeight" value="0" data-calculatePrice-grossWeight disabled>
								<span class="input-group-addon">гр.</span>
							</div>
						</div>

						<div class="form-group col-md-4">
							<label for="workmanship">Изработка:</label>
							
							<div class="input-group">
								<input type="number" class="form-control workmanship worksmanship_price" name="workmanship" id="workmanship" value="0" data-calculatePrice-worksmanship>
								<span class="input-group-addon">лв</span>
							</div>
						</div>

						<div class="form-group col-md-4">
							<label for="price">Цена:</label>
							
							<div class="input-group">
								<input type="number" class="form-control final_price price" name="price" id="price" value="0" data-calculatePrice-final>
								<span class="input-group-addon">лв</span>
							</div>
						</div>
						
						<div class="col-12">
							<hr>
						</div>
          </div>

					<div class="form-row">
						<div class="form-group col-md-12">
							<label>Магазин:</label>

              <select 
                name="store_id" 
                class="form-control"
                data-search="/ajax/select_search/stores/" 
                @if ($disable_store_select) disabled @endif
              >
								<option value="{{ $user_store->id }}">{{ $user_store->name }} - {{ $user_store->location }}</option>
							</select>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="grossWeight">Брой:</label>
							
							<div class="input-group">
								<input type="number" class="form-control" name="quantity" id="quantity" value="1">
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="grossWeight">Описание:</label>
							
							<div class="input-group">
								<textarea class="form-control" name="content" id="notes" placeholder="Описание на поръчката"></textarea>
							</div>
						</div>
						
						<div class="col-12">
							<hr>
						</div>
					</div>

					<div class="given-material">
						<div class="form-row">
							<div class="form-group col-md-12">
								<strong>Даден материал:</strong>
							</div>
						</div>
						{!! $givenMaterialRowTpl !!}
					</div>

					<div class="form-row pt-3">
						<div class="form-group col-md-6 mt-auto">
							<button id="btnAddAnother" class="action--state_button add-btn-modal btn btn-primary">
								Добави друг
							</button>
						</div>
						
						<div class="col-12">
							<hr>
						</div>
					</div>
					
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="grossWeight">Капаро:</label>
							
							<div class="input-group">
								<input type="number" class="form-control" name="earnest" id="earnest" placeholder="0">
							</div>
						</div>

						<div class="form-group col-md-6">
							<label for="grossWeight">Фискален бон:</label>

							<button class="action--state_button add-btn-modal btn btn-primary" data-manual-receipt>
								Ръчно пускане на фискален бон
							</button>
						</div>
					</div>
					
					
				</div>
				
				<div id="errors-container"></div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Затвори
					</button>
					<button type="submit" id="add" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">
						Създай поръчка
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade edit--modal_holder" id="editOrder" role="dialog" aria-labelledby="editOrderLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content"></div>
	</div>
</div>

<h3>
	Поръчки
	<button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="orders" data-toggle="modal" data-target="#addOrder">
		Добави
	</button>
</h3>

<table id="main_table" class="table table-condensed tablesort">
	<thead>
		<tr>
			<th>Уникален номер</th>
			<th>Магазин номер</th>
      <th>Модел</th>
			<th>Снимка на модел</th>
			<th>Вид бижу</th>
			<th data-sort-method="none">Цена на грам</th>
			<th data-sort-method="none">Тегло</th>
			<th>Цена</th>
			<th>Дата</th>
			<th>Статус</th>
			<th data-sort-method="none">Действия</th>
		</tr>
	</thead>
	<tbody>
		@foreach($orders as $order)
			@if($loggedUser->role != 'admin' && $loggedUser->role != 'storehouse' && $loggedUser->store_id == $order->store_id)
				@include('admin.orders.table')
			@elseif($loggedUser->role == 'admin' || $loggedUser->role == 'storehouse')
				@include('admin.orders.table')
			@endif
		@endforeach
	</tbody>
</table>
@endsection

@section('footer-scripts')
<script>
	var newStoneRow = '{!! $newStoneRow !!}',
		givenMaterialRow = '{!! $givenMaterialRowTpl !!}';				
</script>
@endsection
