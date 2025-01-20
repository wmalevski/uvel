@extends('admin.layout')

@php

$newStoneRow =
                '<div class="form-group col-md-8"><label>Камък:</label>
                    <select name="stones[]" class="form-control" data-calculatePrice-stone data-search="/ajax/select_search/stones/">
                        <option value="">Избери</option>';
                        $newStoneRow .= '</select>
                </div>
                <div class="form-group col-md-3">
                    <label>Брой:</label>
                    <input type="text" value="" class="form-control calculate-stones" name="stone_amount[]" data-calculateStones-amount placeholder="Брой">
                </div>
                <div class="form-group col-md-1">
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
	@if(in_array($loggedUser->role, ['storehouse', 'admin']))
		<div class="modal fade edit--modal_holder" id="editProduct" role="dialog" aria-labelledby="editProductLabel"
			 aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content"></div>
			</div>
		</div>

		<div class="modal fade add--modal_holder" id="addProduct" role="dialog" aria-labelledby="addProductLabel"
			 aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content"></div>
			</div>
		</div>

		<h3>
			Добави готово изделие
			<button data-url="products/create" type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="products"
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
				<h5 class="modal-title" id="editModelLabel">Информация за продукта</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="info-cont"></div>
				{{ csrf_field() }}
				<h3><span class="product-name"></span></h3>
				<h6><span class="product-jewel"></span></h6>
				<hr>
				<img class="product-image" src="" />
				<ul>
					<li>Уникален номер - <span class="product-id"></span></li>
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
					<li><span class="product-barcode"></span></li>
					<li><span class="product-barcode-identifier"></span></li>
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
				<input class="filter-input form-control" name="search" type="text" data-dynamic-search-param="byCode=" placeholder="Номер">
			</th>
			<th>
				<input class="filter-input form-control" name="search" type="text" data-dynamic-search-param="byName=" placeholder="Модел">
			</th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th>
				<input class="filter-input form-control" name="search" type="number" data-dynamic-search-param="byBarcode=" placeholder="Баркод">
			</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($products as $product)
			@if($loggedUser->role != 'admin' && $loggedUser->role != 'storehouse' && $product->store_info->id == $loggedUser->store_id)
				@include('admin.products.table')
			@elseif($loggedUser->role == 'admin' || $loggedUser->role == 'storehouse')
				@include('admin.products.table')
			@endif
		@endforeach
	</tbody>
</table>

<!-- Paginator -->
{{ $products->appends(request()->except('page'))->links() }}

@endsection

@section('footer-scripts')
<script>
	var newStoneRow = '{!! $newStoneRow !!}';
</script>
@endsection
