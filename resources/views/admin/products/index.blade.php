@extends('admin.layout')
@php
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
	@if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['storehouse', 'admin']))
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
									<input type="checkbox" id="weightWithStones" name="with_stones" class="peer"
										   data-calculatePrice-withStones>
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
									<select data-url="ajax/products/" name="model_id"
											class="model-select form-control model-filled" data-calculatePrice-model
											data-search="/ajax/select_search/models/">
										<option value="">
											Избери
										</option>
									</select>
								</div>
								<div class="form-group col-md-6">
									<label>
										Вид:
									</label>
									<select name="jewel_id" class="jewels_types form-control" data-modelFilled-jewel
											disabled data-search="/ajax/select_search/jewels/">
										<option value="">
											Избери
										</option>
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
									<select name="material_id" class="material_type form-control material calculate"
											data-calculatePrice-material disabled
											data-search="/ajax/select_search/global/materials/">
										<option value="">
											Избери
										</option>
									</select>
								</div>

								<div class="form-group col-md-6">
									<label>
										Цена:
									</label>
									<select id="retail_prices" name="retail_price_id"
											class="form-control calculate prices-filled retail-price retail_prices"
											data-calculatePrice-retail disabled>
										<option value="">
											Избери
										</option>

										@foreach($prices->where('type', 'sell') as $price)
											<option value="{{ $price->id }}" data-retail="{{ $price->price }}"
													data-material="{{ $price->material }}">
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
										<input type="text" class="form-control weight calculate" id="weight"
											   name="weight"
											   data-calculatePrice-netWeight placeholder="Тегло:" min="1" max="10000">
										<span class="input-group-addon">гр.</span>
									</div>
								</div>

								<div class="form-group col-md-3">
									<label for="size">
										Размер:
									</label>
									<input type="text" class="form-control size" id="size" name="size"
										   placeholder="Размер:" min="1" data-modelFilld-size max="10000">
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
										<input type="text" class="form-control" id="totalStones" name="totalStones"
											   data-calculateStones-total disabled>
										<span class="input-group-addon">гр.</span>
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
										<input type="number" class="form-control" name="gross_weight" id="grossWeight"
											   value="0" data-calculatePrice-grossWeight disabled>
										<span class="input-group-addon">гр.</span>
									</div>
								</div>

								<div class="form-group col-md-4">
									<label for="workmanship">
										Изработка:
									</label>
									<div class="input-group">
										<input type="number" class="form-control workmanship worksmanship_price"
											   name="workmanship" id="workmanship"
											   value="0" data-calculatePrice-worksmanship>
										<span class="input-group-addon">
									лв
								</span>
									</div>
								</div>

								<div class="form-group col-md-4">
									<label for="price">Цена: </label>
									<div class="input-group">
										<input type="number" class="form-control final_price price" name="price"
											   id="price" value="0" data-calculatePrice-final>
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
									<select name="store_id" class="store-select form-control"
											data-search="/ajax/select_search/stores/">
										<option value="">
											Избери магазин
										</option>
									</select>
								</div>

								<div class="col-12">
									<hr>
								</div>
							</div>

							<div class="drop-area" name="add">
								<input type="file" name="images" class="drop-area-input" id="fileElem-add" multiple
									   accept="image/*">
								<label class="button" for="fileElem-add">
									Select some files
								</label>
								<div class="drop-area-gallery"></div>
							</div>

							<div class="form-row bot-row">
								<div class="form-group col-md-6">
									<div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 mt-3">
										<input type="checkbox" id="website_visible" name="website_visible" class="peer"
											   checked>
										<label for="website_visible" class="peers peer-greed js-sb ai-c">
									<span class="peer peer-greed">
										Показване в сайта
									</span>
										</label>
									</div>
								</div>
							</div>

							<div id="errors-container"></div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								Затвори
							</button>
							<button type="submit" id="add" data-state="add_state"
									class="action--state_button add-btn-modal btn btn-primary">
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
			<button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="products"
					data-toggle="modal" data-target="#addProduct">
				Добави
			</button>
		</h3>
	@else
		<h3>
			Продукти
		</h3>
		<p>Преглед на продукти</p>
	@endif



<div class="modal fade product-information-modal" id="productInformation" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editModelLabel">Информация за модела</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="info-cont"></div>
				{{ csrf_field() }}
				<h3><span class="product-name">Тест</span></h3>
				<h6><span class="product-jewel">Бижу 1</span><h6>
				<hr>
				<img class="product-image" src="" />
				<ul>
					<li>Материал - <span class="product-material"></span></li>
					<li>Тегло - <span class="product-weight"></span></li>
					<li>Размер - <span class="product-size"></span></li>
					<li>Цена - <span class="product-price"></span></li>
					<li>Изработка - <span class="product-workmanship"></span></li>
					<li>Камъни -  
						<span class="product-stones"></span>
						<ul class="product-stones-inner">
							
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<table id="main_table" class="table table-condensed tablesort table-fixed">
	<thead>
		<tr data-sort-method="thead">
			<th data-sort-method="none">Снимка</th>
			<th data-sort-method="none">Уникален номер</th>
			<th>Модел</th>
			<th>Размер</th>
			<th>Магазин</th>
			<th>Материал</th>
			<th>Цена на грам</th>
			<th>Тегло</th>
			<th>Цена</th>
			<th>Изработка</th>
			<th>Статус</th>
			<th data-sort-method="none">Действия</th>
		</tr>
		
		<tr class="search-inputs" data-dynamic-search-url="ajax/search/products/">
			<th></th>
			<th>
				<input class="filter-input form-control" type="text" data-dynamic-search-param="byCode=" placeholder="Търси по номер">
			</th>
			<th>
				<input class="filter-input form-control" type="text" data-dynamic-search-param="byName=" placeholder="Търси по модел">
			</th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th>
				<input class="filter-input form-control" type="number" data-dynamic-search-param="byBarcode=" placeholder="Търси по баркод">
			</th>
			<th></th>
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
<script>
	var newStoneRow = '{!! $newStoneRow !!}';
</script>
@endsection
