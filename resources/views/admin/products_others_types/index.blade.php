@extends('admin.layout')

@section('content')
<div class="modal fade" id="addProduct" role="dialog" aria-labelledby="addProductlLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductLabel">Добавяне на тип</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="productsOthersTypes" data-type="add" action="productsotherstypes" autocomplete="off">


                <div class="modal-body">

                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Име на типа:">
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

<div class="modal fade edit--modal_holder" id="editProductType" role="dialog" aria-labelledby="editProductTypelLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
        </div>
    </div>
</div>

<h3>Добави друг тип <button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="otherProductsTypes" data-toggle="modal" data-target="#addProduct">Добави</button></h3>

<table class="table table-condensed">
    <thead>
        <tr data-sort-method="thead">
            <th>Име</th>
            <th data-sort-method="none"></th>
        </tr>
        <tr class="search-inputs" data-dynamic-search-url="ajax/search/products_others_types/">
            <th>
                <input class="filter-input form-control" type="text" data-dynamic-search-param="byName=" placeholder="Търси по име">
            </th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>
        @foreach($products_others_types as $type)
            @include('admin.products_others_types.table')
        @endforeach
    </tbody>
</table>

@endsection
