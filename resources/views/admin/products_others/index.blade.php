@extends('admin.layout')

@section('content')
<div class="modal fade" id="addProduct"   role="dialog" aria-labelledby="addProductlLabel"
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
                        <select id="type " name="type" class="form-control">
                            <option value="">Избери</option>
                    
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="1">Цена: </label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Цена на брой:">
                    </div>

                    <div class="form-group">
                        <label for="1">Количество: </label>
                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Налично количество:">
                    </div>

                    <div class="form-group">
                        <label>Магазин: </label>
                        <select id="store " name="store" class="form-control">
                            <option value="">Избери</option>
                    
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
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

<h3>Добави друг продукт <button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="otherProducts" data-toggle="modal" data-target="#addProduct">Добави</button></h3>

<table class="table table-condensed tablesort">
    <tr>
        <th>Баркод</th> 
        <th>Модел</th>
        <th>Цена/бр</th>
        <th>Количество</th>
        <th>Магазин</th>
        <th>Уникален номер</th>
        <th>Опции</th>
    </tr>
    
    @foreach($products_others as $product)
        @include('admin.products_others.table')
    @endforeach
</table>

@endsection