@extends('admin.layout')
@php
$newMaterialRow =
				'<div class="form-group col-md-6">
					<label>Избери материал: </label>
					<select data-search="/ajax/select_search/global/materials/" name="material_id[]" class="material_type form-control calculate" data-calculatePrice-material>
						<option value="">Избери</option>';
						
						$newMaterialRow .= '</select>
				</div>
				<div class="form-group col-md-5">
					<label>Цена:</label>
					<select name="retail_price_id[]" class="form-control calculate prices-filled retail-price retail_prices" data-calculatePrice-retail disabled>
						<option value="">Избери</option>
					</select>
				</div>
				<div class="form-group col-md-1">
					<span class="delete-material remove_field" data-materials-remove><i class="c-brown-500 ti-trash"></i></span>
				</div>
				<div class="form-group col-md-12">
					<div class="radio radio-info">
						<input type="radio" id="" class="default_material not-clear" name="default_material[]" data-calculatePrice-default checked>
						<label for=""><span>Материал по подразбиране</span></label>
					</div>
				</div>';

$newMaterialRow = str_replace("\n", "", str_replace("\r", "", $newMaterialRow));

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
							<input type="number" value="" class="form-control calculate-stones" name="stone_weight[]" data-calculateStones-weight placeholder="Тегло:" min="0.1" max="100">
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

<div class="modal fade" id="addModel" role="dialog" aria-labelledby="addModelLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addModelLabel">Добавяне на модел</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="models" name="models" data-type="add" autocomplete="off">
				<div class="modal-body">
					<div class="info-cont"></div>
					{{ csrf_field() }}
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="1">Име:</label>
							<input type="text" class="form-control" id="1" name="name" placeholder="Име:">
						</div>
						<div class="form-group col-md-6">
							<label>
								Избери вид бижу:
							</label>
							<select name="jewel_id" class="form-control calculate" data-search="/ajax/select_search/jewels/">
								<option value="">
									Избери
								</option>
							</select>
						</div>

						<div class="col-12">
							<hr>
						</div>
					</div>

					<div class="model_materials">
						<div class="form-row not-clear">
							{!! $newMaterialRow !!}
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-6">
							<button type="button" class="btn btn-primary add_field_variation" data-addMaterials-add>
								Добави нова комбинация
							</button>
						</div>
						
						<div class="col-12">
							<hr>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-6 weight-holder">
							<label for="weight">Нетно тегло:</label>
							<div class="input-group">
								<input type="number" class="form-control calculate" id="weight" name="weight" data-calculatePrice-netWeight placeholder="Тегло:">
								<span class="input-group-addon">гр.</span>
								<input type="number" class="form-control form-control--hidden" name="gross_weight" id="grossWeight_edit" value="0" data-calculateprice-grossweight="" disabled="">
							</div>
						</div>

						<div class="form-group col-md-6">
							<label for="1">Размер:</label>
							<input type="number" class="form-control" id="1" name="size" placeholder="Размер:">
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
								<input type="number" class="form-control" id="totalStones" name="totalStones" data-calculateStones-total disabled>
								<span class="input-group-addon">гр.</span>
							</div>
						</div>
						
						<div class="col-12">
							<hr>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Избработка:</label>
							<div class="input-group">
								<input id="workmanship" type="number" class="form-control worksmanship_price" value="0" name="workmanship" data-calculatePrice-worksmanship>
								<span class="input-group-addon">лв</span>
							</div>
						</div>

						<div class="form-group col-md-6">
							<label>Цена:</label>
							<div class="input-group">
								<input id="price" type="number" class="form-control final_price" value="0" name="price" data-calculatePrice-final>
								<span class="input-group-addon">лв</span>
							</div>
						</div>
						
						<div class="col-12">
							<hr>
						</div>
					</div>

					<div class="drop-area" name="add">
						<input type="file" name="images" class="drop-area-input" id="fileElem-add" multiple accept="image/*">
						<label class="button" for="fileElem-add">Select some files</label>
						<div class="drop-area-gallery"></div>
					</div>

					<div class="form-row bot-row">
						<div class="form-group col-md-6">
							<div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 mt-3">
								<input type="checkbox" id="website_visible" name="website_visible" class="peer" checked>
								<label for="website_visible" class="peers peer-greed js-sb ai-c">
									<span class="peer peer-greed">Показване в сайта</span>
								</label>
							</div>
						</div>
					</div>

					<div class="form-row bot-row">
						<div class="form-group col-md-6">
							<div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 mt-3">
								<input type="checkbox" id="checkbox_website_add" name="release_product" class="peer">
								<label for="checkbox_website_add" class="peers peer-greed js-sb ai-c">
									<span class="peer peer-greed">Добави като продукт</span>
								</label>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Затвори
					</button>
					<button type="submit" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">
						Добави
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade edit--modal_holder" id="editModel" role="dialog" aria-labelledby="editModelLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editModelLabel">Редактиране на модел</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="info-cont"></div>
				{{ csrf_field() }}
			</div>
		</div>
	</div>
</div>

<h3>
	Модели
	<button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="models" data-toggle="modal" data-target="#addModel">
		Добави
	</button>
</h3>

<table id="main_table" class="table table-condensed models-table tablesort table-fixed">
	<thead>
		<tr data-sort-method="thead">
			<th>Снимка</th>
			<th>Име</th>
			<th>Тегло</th>
			<th>Цена</th>
			<th>Изработка</th>
			<th data-sort-method="none">Действия</th>
			<th data-sort-method="none">Камъни</th>
		</tr>

		<tr class="search-inputs" data-dynamic-search-url="ajax/search/models/">
			<th></th>
			<th>
				<input class="filter-input form-control" type="text" data-dynamic-search-param="byName=" placeholder="Търси по име">
			</th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	
	<tbody>
		@foreach($models as $model)
			@include('admin.models.table')
		@endforeach
	</tbody>
</table>
@endsection

@section('footer-scripts')
<script>
	var newMaterialRow = '{!! $newMaterialRow !!}',
		newStoneRow = '{!! $newStoneRow !!}';
</script>
@endsection
