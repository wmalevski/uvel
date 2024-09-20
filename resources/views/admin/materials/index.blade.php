@extends('admin.layout')

@section('content')
<div class="modal fade" id="addMaterial" role="dialog" aria-labelledby="addMateriallLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMaterialLabel">Добавяне на материал</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" data-type="add" name="materials" action="materials" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <div id="success-container"></div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Наследява: </label>
                            <select name="parent_id" class="form-control">
                                <option value="">Избери материал: </option>
                        
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="2">Проба: </label>
                            <input type="number" class="form-control" id="2" name="code" placeholder="Проба:">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="3">Цвят: </label>
                            <input type="text" class="form-control" id="3" name="color" placeholder="Цвят:">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="3">Карат: </label>
                            <input type="number" class="form-control" id="4" name="carat" placeholder="Карати:">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="cash_group">Касова група: </label>
                            <input type="number" class="form-control" id="cash_group" name="cash_group" placeholder="Касова група:">
                        </div>
                    </div>
                    
                    <div class="form-row mt-3">
                        <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                            <input type="checkbox" id="for_buy" name="for_buy" class="peer" checked>
                            <label for="for_buy" class="peers peer-greed js-sb ai-c">
                                <span class="peer peer-greed">За изкупуване</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-row mt-3">
                        <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                            <input type="checkbox" id="for_exchange" name="for_exchange" class="peer">
                            <label for="for_exchange" class="peers peer-greed js-sb ai-c">
                                <span class="peer peer-greed">За обмяна</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-row mt-3">
                        <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                            <input type="checkbox" id="carat_transform" name="carat_transform" class="peer" checked>
                            <label for="carat_transform" class="peers peer-greed js-sb ai-c">
                                <span class="peer peer-greed">Преобразуване на карати</span>
                            </label>
                        </div>
                    </div>
                    <div id="errors-container"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editMaterial" role="dialog" aria-labelledby="editMaterialLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Материали <button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="materials" data-toggle="modal" data-target="#addMaterial">Добави</button></h4>
        <p>Преглед на създадените материали.</p>
        <table id="main_table" class="table table-fixed">
            <thead>
                <tr data-sort-method="thead">
                    <th>Тип</th>
                    <th>Проба</th> 
                    <th>Цвят</th> 
                    <th>Карат</th>
                    <th>Касова група</th>
                    <th>Борсова Цена</th>
                    <th data-sort-method="none">Действия</th> 
                </tr>
                <tr class="search-inputs" data-dynamic-search-url="ajax/search/materials/">
                    <th></th>
                    <th>
                        <input class="filter-input form-control" name="search" type="text" data-dynamic-search-param="byCode=" placeholder="Проба">
                    </th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($materials as $material)
                    @include('admin.materials.table')
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>
@endsection
