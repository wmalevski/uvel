@extends('admin.layout')

@section('content')
<div class="modal fade add--modal_holder" id="addProduct" role="dialog" aria-labelledby="addProductlLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editProduct" role="dialog" aria-labelledby="editProductlLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>

<h3>Добави друг продукт
    @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'storehouse']))
        <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#addProduct" data-form-type="add" data-form="otherProducts" data-url="productsothers/create">Добави</button>
    @endif
</h3>

<table id="main_table" class="table table-condensed tablesort table-fixed">
    <thead>
        <tr data-sort-method="thead">
            <th>Снимка</th>
            <th>Уникален номер</th>
            <th data-sort-method="none">Баркод</th> 
            <th>Модел</th>
            <th>Цена/бр</th>
            <th>Количество</th>
            <th>Магазин</th>
            <th data-sort-method="none">Опции</th>
        </tr>
        <tr class="search-inputs" data-dynamic-search-url="ajax/search/products_others/">
            
            <th></th>
            <th>
                <input class="filter-input form-control" name="search" type="text" data-dynamic-search-param="byCode=" placeholder="Уникален номер">
            </th>
            <th>
                <input class="filter-input form-control" name="search" type="text" data-dynamic-search-param="byBarcode=" placeholder="Баркод">
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>
        @foreach($products_others as $product)
            @if(\Illuminate\Support\Facades\Auth::user()->role == 'cashier' && $product->store->id == \Illuminate\Support\Facades\Auth::user()->store_id)
                @include('admin.products_others.table')
            @elseif(\Illuminate\Support\Facades\Auth::user()->role != 'cashier')
                @include('admin.products_others.table')
            @endif
        @endforeach
    </tbody>
</table>

@endsection
