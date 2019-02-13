@extends('admin.layout')

@section('content')
<div class="modal fade" id="addMQuantity" role="dialog" aria-labelledby="addMQuantity"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMQuantityLabel">Добавяне на материал</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" data-type="add" name="materialsQuantity" action="mquantity" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <div id="success-container"></div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Тип: </label>
                            <select name="material_id" class="form-control" data-search="/ajax/select_search/parentmaterials/">
                                <option value="">Избери материал</option>
                        
                                @foreach($types as $type)
                            
                                    <option value="{{ $type->id }}">@if($type->parent) {{ $type->parent->name }} - {{ $type->color }} - {{ $type->code }} @endif</option>
                                }
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="2">Количество:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="2" name="quantity" placeholder="Количество:" min="1">
                                <span class="input-group-addon">гр.</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Магазин: </label>
                        <select name="store_id" class="form-control" data-search="/ajax/select_search/stores/">
                            <option value="">Избери магазин</option>
                    
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }} - {{ $store->location }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="errors-container"></div>
                </div>

                {{-- <input type="hidden" name="store" value="{{ Auth::user()->store }}"> --}}

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editMQuantity" role="dialog" aria-labelledby="editMQuantityLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Налични материали 
            <button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="materialsQuantity" data-toggle="modal" data-target="#addMQuantity">Добави</button>
        </h4>
        <p>Преглед на наличност.</p>
        <table class="table table-condensed">
            <thead>
                <tr data-sort-method="thead">
                    <th>Тип</th> 
                    <th>Количество/гр</th> 
                    <th>Магазин</th>
                    <th data-sort-method="none">Действия</th> 
                </tr>
                <tr class="search-inputs" data-dynamic-search-url="ajax/search/materialquantities/">
                    <th>
                        <input class="filter-input form-control" type="text" data-dynamic-search-param="byName=" placeholder="Търси по тип">
                    </th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($materials as $material)
                    @include('admin.materials_quantity.table')
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>
@endsection
