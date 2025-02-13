@extends('admin.layout')
@php
$userRole = Auth::user()->role;
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
@if($errors->any())
  <div class="d-flex flex-column justify-content-center align-items-center p-2">
    @foreach($errors->all() as $error)
      <p class="alert-danger">{{$error}}</p>
    @endforeach
  </div>
@endif

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

<div class="modal fade add--modal_holder" id="addModel" role="dialog" aria-labelledby="addModelLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content"></div>
    </div>
</div>
{{-- <div class="modal fade model-information-modal" id="modelInformation" role="dialog" aria-hidden="true">
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
				<h3><span class="product-name"></span></h3>
				<h6><span class="product-jewel"></span><h6>
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
</div> --}}

<h3>Модели
@if(in_array($userRole, array('admin', 'storehouse')))
{{-- <button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="models" data-toggle="modal" data-target="#addModel">Добави</button> --}}
<button data-url="models/create" type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="models"
data-toggle="modal" data-target="#addModel">
Добави
</button>
@endif</h3>

<table id="main_table" class="table table-condensed models-table tablesort table-fixed">
	<thead>
		<tr data-sort-method="thead">
			<th width="8%">Снимка</th>
			<th width="17%">Име</th>
			<th width="10%">Тегло</th>
			<th width="20%">Цена/гр</th>
			<th width="8%">Цена</th>
			<th width="10%">Изработка</th>
			@if(in_array($userRole, array('admin', 'storehouse')))<th width="7%" data-sort-method="none">Действия</th>@endif
			<th width="13%" data-sort-method="none">Камъни</th>
			<th width="7%" data-sort-method="none"></th>
		</tr>

		<tr class="search-inputs" data-dynamic-search-url="ajax/search/models/">
			<th width="8%"></th>
			<th width="17%"><input class="filter-input form-control" name="search" type="text" data-dynamic-search-param="byName=" placeholder="Име"/></th>
			<th width="10%"></th>
			<th width="20%"></th>
			<th width="8%"></th>
			<th width="10%"></th>
			@if(in_array($userRole, array('admin', 'storehouse')))<th width="7%"></th>@endif
			<th width="13%"></th>
			<th width="7%"></th>
		</tr>
	</thead>

	<tbody>
		@foreach($models as $model)
			@include('admin.models.table')
		@endforeach
	</tbody>
</table>

<!-- Paginator -->
{{ $models->appends(request()->except('page'))->links() }}

@endsection

@section('footer-scripts')
<script>
	var newMaterialRow = '{!! $newMaterialRow !!}',
		newStoneRow = '{!! $newStoneRow !!}';
</script>
@endsection
