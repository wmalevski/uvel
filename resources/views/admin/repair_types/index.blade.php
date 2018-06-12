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
            <form method="POST" name="addRepairType" action="/repairtypes" autocomplete="off">
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
                        <input type="number" class="form-control" id="1" name="price" placeholder="Цена на ремонтната дейност:" min="0">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" class="add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editRepairType" role="dialog" aria-labelledby="editRepairType"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Ремонтни дейности <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#addRepairType">Добави</button></h4>
            <p>Преглед на създадените ремонтни дейности.</p>
            <table class="table table-condensed tablesort">
                <thead>
                    <tr>
                        <th>Име</th> 
                        <th class="sort-false">Цена</th>
                        <th class="sort-false">Опции</th>
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