@extends('admin.layout')

@section('content')
<div class="modal fade edit--modal_holder" id="editCashGroup" tabindex="-1"  role="dialog" aria-labelledby="editCashGroup">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>
<div class="modal fade" id="addCashGroup"   role="dialog" aria-labelledby="addRepairTypeLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCashGroupLabel">Добавяне на касова група</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" data-type="add" name="cashGroups" action="{{route('store_cashgroup')}}" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont"></div>
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="1">Име:</label>
                        <input type="text" class="form-control" id="1" name="label" placeholder="За:">
                    </div>
                    <div class="form-group">
                        <label for="1">Група:</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="1" name="cash_group" placeholder="Група:" min="0">
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

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Касови групи <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#addCashGroup" data-form-type="add" data-form="repairTypes">Добави</button></h4>
            <p>Преглед на касовите групи.</p>
            <table id="main_table" class="table">
              <thead>
                <tr>
                  <th scope="col">За</th> 
                  <th scope="col">Касова група</th>
                  <th scope="col">Действия</th>
                </tr>
              </thead>
              <tbody>
                @foreach($cashgroups as $cashgroup)
                    @if(Auth::user()->role == 'admin')
                        @include('admin.settings.cashgroups.table')
                    @endif
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>

@endsection