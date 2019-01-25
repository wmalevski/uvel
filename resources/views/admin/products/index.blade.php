@extends('admin.layout')

@section('content')
<div class="modal fade" id="addProduct" role="dialog" aria-labelledby="addProductlLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addProductLabel">
					Добавяне на продукт
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" name="products" data-type="add" action="products" autocomplete="off">
				<div class="modal-body">
					<div class="info-cont"></div>
					{{ csrf_field() }}
					<div class="form-row">
						<div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
							<input type="checkbox" id="weightWithStones" name="with_stones" class="peer" data-calculatePrice-withStones>
							<label for="weightWithStones" class="peers peer-greed js-sb ai-c">
								<span class="peer peer-greed">
									Тегло с камъни
								</span>
							</label>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-6">
							<label>
								Модел:
							</label>
							<select data-url="ajax/products/" name="model_id" class="model-select form-control model-filled" data-calculatePrice-model>
								<option value="">
									Избери
								</option>
								@foreach($models as $model)
								<option value="{{ $model->id }}" data-jewel="{{ $model->jewel->id }}">
									{{ $model->name }}
								</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>
								Вид:
							</label>
							<select id="jewels_types" name="jewel_id" class="jewels_types form-control" data-modelFilled-jewel disabled>
								<option value="">
									Избери
								</option>

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
							<label>
								Материал:
							</label>
							<select id="material" name="material_id" class="material_type form-control material calculate" data-calculatePrice-material disabled>
								<option value="">
									Избери
								</option>

								@foreach($materials as $material)
								@if($material->material->pricesBuy->first() && $material->material->pricesSell->first())
								{{-- {{ $material->material->prices }} --}}
								<option value="{{ $material->id }}" data-material="{{ $material->material->id }}" data-pricebuy="{{ $material->material->pricesBuy->first()->price }}">
									@if($material->material->parent)
									{{ $material->material->parent->name }}
									@else {{ $material->material->name }} @endif
									-
									{{ $material->material->color }} -
									{{ $material->material->carat }}
								</option>
								@endif
								@endforeach
							</select>
						</div>

						<div class="form-group col-md-6">
							<label>
								Цена:
							</label>
							<select id="retail_prices" name="retail_price_id" class="form-control calculate prices-filled retail-price retail_prices" data-calculatePrice-retail disabled>
								<option value="">
									Избери
								</option>

								@foreach($prices->where('type', 'sell') as $price)
								<option value="{{ $price->id }}" data-retail="{{ $price->price }}" data-material="{{ $price->material }}">
									{{ $price->slug }} - {{ $price->price }}
								</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-3 weight-holder">
							<label for="weight">
								Нетно тегло:
							</label>
							<div class="input-group">
								<input type="text" class="form-control weight calculate" id="weight" name="weight"
								 data-calculatePrice-netWeight placeholder="Тегло:" min="1" max="10000">
								<span class="input-group-addon">
									гр
								</span>
							</div>
						</div>

						<div class="form-group col-md-3">
							<label for="size">
								Размер:
							</label>
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
							<label for="totalStones">
								Общо за леене:
							</label>
							<div class="input-group">
								<input type="text" class="form-control" id="totalStones" name="totalStones" data-calculateStones-total disabled>
								<span class="input-group-addon">
									гр
								</span>
							</div>
						</div>

						<div class="col-12">
							<hr>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="grossWeight">
								Брутно тегло:
							</label>
							<div class="input-group">
								<input type="number" class="form-control" name="gross_weight" id="grossWeight" value="0" data-calculatePrice-grossWeight disabled>
								<span class="input-group-addon">
									гр
								</span>
							</div>
						</div>

						<div class="form-group col-md-4">
							<label for="workmanship">
								Изработка:
							</label>
							<div class="input-group">
								<input type="number" class="form-control workmanship worksmanship_price" name="workmanship" id="workmanship"
								 value="0" data-calculatePrice-worksmanship>
								<span class="input-group-addon">
									лв
								</span>
							</div>
						</div>

						<div class="form-group col-md-4">
							<label for="price">Цена: </label>
							<div class="input-group">
								<input type="number" class="form-control final_price price" name="price" id="price" value="0" data-calculatePrice-final>
								<span class="input-group-addon">
									лв
								</span>
							</div>
						</div>
						
						<div class="col-12">
							<hr>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-12">
							<label>
								Магазин:
							</label>
							<select name="store_id" class="store-select form-control">
								<option value="">
									Избери магазин
								</option>

								@foreach($stores as $store)
								<option value="{{ $store->id }}">
									{{ $store->name }} - {{ $store->location }}
								</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 mt-3">
						<input type="checkbox" id="website_visible" name="website_visible" class="peer" checked>
						<label for="website_visible" class="peers peer-greed js-sb ai-c">
							<span class="peer peer-greed">
								Показване в сайта
							</span>
						</label>
					</div>

					<div class="drop-area" name="add">
						<input type="file" name="images" class="drop-area-input" id="fileElem-add" multiple accept="image/*">
						<label class="button" for="fileElem-add">
							Select some files
						</label>
						<div class="drop-area-gallery"></div>
					</div>

					<div id="errors-container"></div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Затвори
					</button>
					<button type="submit" id="add" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">
						Добави
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade edit--modal_holder" id="editProduct" role="dialog" aria-labelledby="editProductLabel"
 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content"></div>
	</div>
</div>

<h3>
	Добави готово изделие
	<button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="products" data-toggle="modal" data-target="#addProduct">
		Добави
	</button>
</h3>

<table class="table table-condensed tablesort">
	<thead>
		<tr data-sort-method="thead">
			<th data-sort-method="none">Снимка</th>
			<th data-sort-method="none">Уникален номер</th>
			<th>Модел</th>
			<th>Вид бижу</th>
			<th data-sort-method="none">Цена на дребно</th>
			<th data-sort-method="none">Тегло</th>
			<th>Цена</th>
			<th data-sort-method="none">Баркод</th>
			<th>Статус</th>
			<th data-sort-method="none">Действия</th>
		</tr>
		
		<tr class="search-inputs">
			<th></th>
			<th>
				<input class="filter-input form-control" type="text" data-search-attribute="data-code" placeholder="Търси по номер">
			</th>
			<th>
				<input class="filter-input form-control" type="text" data-search-attribute="data-model" placeholder="Търси по модел">
			</th>
			<th>
				<input class="filter-input form-control" type="text" data-search-attribute="data-type" placeholder="Търси по вид">
			</th>
			<th>
				<input class="filter-input form-control" type="number" data-search-attribute="data-retail-price" placeholder="Търси по цена на дребно">
			</th>
			<th>
				<input class="filter-input form-control" type="number" data-search-attribute="data-weight" placeholder="Търси по тегло">
			</th>
			<th>
				<input class="filter-input form-control" type="number" data-search-attribute="data-price" placeholder="Търси по цена">
			</th>
			<th>
				<input class="filter-input form-control" type="number" data-search-attribute="data-barcode" placeholder="Търси по баркод">
			</th>
			<th></th>
			<th>
				<button type="button" class="btn btn-primary btn-clear-filters">
					<strong>X</strong>
					Изчисти филтри
				</button>
			</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
		@foreach($products as $product)
		@include('admin.products.table')
		@endforeach
	</tbody>
</table>
@endsection

@section('footer-scripts')
<script id="stones_data" type="application/json">
	{!!$jsStones!!}
</script>

@endsection
