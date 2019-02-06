@extends('admin.layout')
@php
$givenMaterialRowTpl = '<div class="form-row">
						<div class="form-group col-md-6"> 
							<label for="">Вид</label>
							<select name="given_material_id[]" data-calculateprice-material class="material_type form-control calculate">
								<option value="">Избери</option>';
								foreach($mats as $material) {
									if($material->material->pricesBuy->first() && $material->material->pricesSell->first()) {
									$givenMaterialRowTpl .= '<option value="'. $material->id .'" data-carat="'. $material->material->carat  .'" data-material="'. $material->material->id  .'"
										data-pricebuy="'. $material->material->pricesBuy->first()->price  .'"> 
										'. $material->material->parent->name  .' - 
										'. $material->material->color  .' - 
										'. $material->material->carat  .' 
									</option>';
									}
								}
							$givenMaterialRowTpl .= '</select>
						</div>
						<div class="form-group col-md-5">
							<label for="grossWeight">Количество:</label>
							
							<div class="input-group">
								<input type="number" class="form-control mat-quantity" name="mat_quantity[]" placeHolder="0">
							</div>
						</div>
						<div class="form-group col-md-1">
							<span class="delete-material remove_field" data-materials-remove><i class="c-brown-500 ti-trash"></i></span>
						</div>
					</div>';

$givenMaterialRowTpl = str_replace("\n", "", str_replace("\r", "", $givenMaterialRowTpl));

$newStoneRow =
				'<div class="form-group col-md-6"><label>Камък:</label>
					<select name="stones[]" class="form-control" data-calculatePrice-stone>';
						foreach($stones as $stone) {
							$newStoneRow .= '<option value="'. $stone->id .'" data-stone-price="'. $stone->price .'" data-stone-type="'. $stone->type .'"> 
								'. $stone->nomenclature->name  .' - 
								'. $stone->contour->name  .' - 
								'. $stone->size->name  .' 
							</option>';
						}
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
							<input type="number" value="" class="form-control calculate-stones" name="stone_weight[]" data-calculateStones-weight placeholder="Тегло:" min="0.1" max="100">
							<span class="input-group-addon">гр</span>
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
							<label>Модел:</label>
							
							<select data-url="ajax/orders/getModelInfo/" name="model_id" class="model-select form-control model-filled" data-calculatePrice-model>
								<option value="">Избери</option>
								
								@foreach($models as $model)
								<option value="{{ $model->id }}" data-model-id="{{ $model->id }}" data-jewel="{{ $model->jewel->id }}">
									{{ $model->name }}
								</option>
								@endforeach
							</select>
						</div>
						
						<div class="form-group col-md-6">
							<label>Вид:</label>
							
							<select id="jewels_types" name="jewel_id" class="jewels_types form-control" data-modelFilled-jewel disabled>
								<option value="">Избери</option>
								
								@foreach($jewels as $jewel)
								<option value="{{ $jewel->id }}" data-material="{{ $jewel->material }}">
									{{ $jewel->name }}
								</option>
								@endforeach
							</select>
						</div>
						
						<div class="col-12">
							<hr>
						</div>
					</div>

					<div class="form-row model_materials">
						<div class="form-group col-md-12">
							<label>Материал:</label>
							
							<select id="material" name="material_id" class="material_type form-control material calculate" data-calculatePrice-material disabled>
								<option value="">Избери</option>
								
								@foreach($materials as $material)
									@if($material->material->pricesBuy->first() && $material->material->pricesSell->first())
										{{-- {{ $material->material->prices }} --}}
										<option value="{{ $material->id }}" data-material="{{ $material->material->id }}"
														data-pricebuy="{{ $material->material->pricesBuy->first()->price }}">
											@if($material->material->parent)
												{{ $material->material->parent->name }}
											@else 
												{{ $material->material->name }}
											@endif
											- {{ $material->material->color }} -
											{{ $material->material->carat }}
										</option>
									@endif
								@endforeach
							</select>
						</div>

						<div class="form-group col-md-6">
							<label>Цена:</label>
							
							<select id="retail_prices" name="retail_price_id" class="form-control calculate prices-filled retail-price retail_prices" data-calculatePrice-retail disabled>
								<option value="0">Избери</option>
							</select>
						</div>
						<div class="form-group col-md-3 weight-holder">
							<label for="weight">Нетно тегло:</label>
							
							<div class="input-group">
								<input type="text" class="form-control weight calculate" id="weight" name="weight" data-calculatePrice-netWeight placeholder="Тегло:" min="1" max="10000">
								<span class="input-group-addon">гр</span>
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
								<span class="input-group-addon">гр</span>
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
								<span class="input-group-addon">гр</span>
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
							
							<select name="store_id" class="form-control">
								<option value="">Избери магазин</option>
								
								@foreach($stores as $store)
								<option value="{{ $store->id }}">
									{{ $store->name }} - {{ $store->location }}
								</option>
								@endforeach
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

<table class="table table-condensed tablesort">
	<thead>
		<tr>
			<th data-sort-method="none">Уникален номер</th>
			<th>Модел</th>
			<th>Вид бижу</th>
			<th data-sort-method="none">Цена на дребно</th>
			<th data-sort-method="none">Тегло</th>
			<th>Цена</th>
			<th>Статус</th>
			<th data-sort-method="none">Действия</th>
		</tr>
	</thead>
	<tbody>
		@foreach($orders as $order)
			@include('admin.orders.table')
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
