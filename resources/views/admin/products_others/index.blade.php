@extends('admin.layout')

@section('content')
<div class="modal fade" id="addProduct" role="dialog" aria-labelledby="addProductlLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductLabel">Добавяне на продукт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="productsOthers" data-type="add" action="productsothers" autocomplete="off">


                <div class="modal-body">

                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="1">Модел: </label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Модел:">
                    </div>
                
                    <div class="form-group">
                        <label>Тип: </label>
                        <select id="type" name="type_id" class="form-control">
                            <option value="">Избери</option>
                    
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="1">Цена: </label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="price" name="price" placeholder="Цена на брой:">
                            <span class="input-group-addon">лв</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="1">Количество: </label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Налично количество:">
                            <span class="input-group-addon">бр.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Магазин: </label>
                        <select id="store " name="store_id" class="form-control">
                    
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="drop-area" name="add">
                        <input type="file" name="images" class="drop-area-input" id="fileElem-add" multiple accept="image/*" >
                        <label class="button" for="fileElem-add">Select some files</label>
                        <div class="drop-area-gallery"></div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
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
        <button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="otherProducts"
                data-toggle="modal" data-target="#addProduct">Добави
        </button>
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
