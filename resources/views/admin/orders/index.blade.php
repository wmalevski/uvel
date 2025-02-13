@extends('admin.layout')
@php
$givenMaterialRowTpl = '<div class="form-row">
	<div class="form-group col-md-6">
		<label>Вид</label>
		<select name="given_material_id[]" data-calculateprice-material class="material_type form-control calculate" data-search="/ajax/select_search/parentmaterials">
			<option value="">Избери</option>
		</select>
	</div>
	<div class="form-group col-md-5">
		<label>Количество:</label>
		<div class="input-group">
			<input type="number" class="form-control mat-quantity" name="mat_quantity[]" placeHolder="0" step="0.01" min="0.01" />
		</div>
	</div>
	<div class="form-group col-md-1">
		<span class="delete-material remove_field" data-materials-remove><i class="c-brown-500 ti-trash"></i></span>
	</div>
</div>';

$givenMaterialRowTpl = str_replace("\n", "", str_replace("\r", "", $givenMaterialRowTpl));
$newStoneRow ='
<div class="form-group col-md-6"><label>Камък:</label>
	<select name="stones[]" class="form-control" data-calculatePrice-stone data-search="/ajax/select_search/stones/">
		<option value="">Избери</option>
	</select>
</div>
<div class="form-group col-md-4">
	<label>Брой:</label>
	<input type="text" value="" class="form-control calculate-stones" name="stone_amount[]" data-calculateStones-amount placeholder="Брой" />
</div>
<div class="form-group col-md-2">
	<span class="delete-stone remove_field" data-stone-remove><i class="c-brown-500 ti-trash"></i></span>
</div>
<div class="form-group col-md-6">
	<div class="form-group">
		<label>Тегло: </label>
		<div class="input-group">
			<input type="number" value="" class="form-control calculate-stones" name="stone_weight[]" data-calculateStones-weight placeholder="Тегло:" min="0.1" max="100" disabled />
			<span class="input-group-addon">гр.</span>
		</div>
	</div>
</div>
<div class="form-group col-md-6">
	<div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 stone-flow-holder">
		<input type="checkbox" id="" class="stone-flow calculate-stones" name="stone_flow[]" class="peer" />
		<label class="peers peer-greed js-sb ai-c">
			<span class="peer peer-greed">За леене</span>
		</label>
		<span class="row-total-weight"></span>
	</div>
</div>';
$newStoneRow = str_replace("\n", "", str_replace("\r", "", $newStoneRow));
@endphp

@section('content')
<div class="modal fade add--modal_holder" id="addOrder" role="dialog" aria-labelledby="addOrderlLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade edit--modal_holder" id="editOrder" role="dialog" aria-labelledby="editOrderLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content"></div>
	</div>
</div>

<h3>Поръчки
	<button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="orders" data-toggle="modal" data-target="#addOrder" data-url="orders/create">Добави</button>
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
	@php
		$userMeta = [
			'userRole' => $loggedUser->role,
			'store_id' => $loggedUser->store_id,
		];
	@endphp

	@foreach($orders as $order)
		@if($userMeta['userRole'] != 'admin' && $userMeta['userRole'] != 'storehouse' && $userMeta['store_id'] ==$order->store_id)
			@include('admin.orders.table')
		@elseif($userMeta['userRole'] == 'admin' || $userMeta['userRole'] == 'storehouse')
			@include('admin.orders.table')
		@endif
	@endforeach
	</tbody>
</table>
{{ $orders->links() }}
@endsection

@section('footer-scripts')
<script>
	var newStoneRow = '{!! $newStoneRow !!}',
	givenMaterialRow = '{!! $givenMaterialRowTpl !!}';
</script>
@endsection