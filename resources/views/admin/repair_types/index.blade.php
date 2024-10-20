@extends('admin.layout')

@section('content')
<div class="modal fade" id="addRepairType"   role="dialog" aria-labelledby="addRepairTypeLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRepairTypeLabel">Добавяне на ремонтна дейност</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" data-type="add" name="repairTypes" action="repairtypes" autocomplete="off">
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}                    
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Име на ремонтната дейност:">
                    </div>

                    <div class="form-group">
                        <label for="1">Цена: </label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="1" name="price" placeholder="Цена на ремонтната дейност:" min="0">
                            <span class="input-group-addon">лв</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editRepairType" role="dialog" aria-labelledby="editRepairType"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Ремонтни дейности <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#addRepairType" data-form-type="add" data-form="repairTypes">Добави</button></h4>
            <p>Преглед на създадените ремонтни дейности.</p>
            <table id="main_table" class="table table-condensed tablesort table-fixed">
                <thead>
                    <tr data-sort-method="thead">
                        <th>Име</th>
                        <th>Цена</th>
                        <th data-sort-method="none">Опции</th>
                    </tr>
                    <tr class="search-inputs" data-dynamic-search-url="ajax/search/repairs_types/">
                        <th>
                            <input class="filter-input form-control" name="search" type="text" data-dynamic-search-param="byName=" placeholder="Име">
                        </th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($repairTypes as $repairType)
                        @include('admin.repair_types.table')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
