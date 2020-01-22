@extends('admin.layout')

@section('content')

<div class="modal fade" id="addStore"   role="dialog" aria-labelledby="addStore"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStoreLabel">Добавяне на магазин</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="stores" name="stores" data-type="add" autocomplete="off">
                 
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Име на магазин:">
                    </div>
                
                    <div class="form-group">
                        <label for="2">Адрес: </label>
                        <input type="text" class="form-control" id="2" name="location" placeholder="Адрес на магазин:">
                    </div>
                
                    <div class="form-group">
                        <label for="3">Телефон: </label>
                        <input type="number" class="form-control" id="3" name="phone" placeholder="Телефон на магазин:">
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

<div class="modal fade edit--modal_holder" id="editStore" tabindex="-1"  role="dialog" aria-labelledby="editStore">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Магазини
            @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                <button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="stores" data-toggle="modal" data-target="#addStore">Добави</button>
            @endif
        </h4>
        <p>Преглед на магазините.</p>
        <table id="main_table" class="table">
            <thead>
            <tr>
                <th scope="col">Уникален номер</th>
                <th scope="col">Име</th>
                <th scope="col">Адрес</th>
                <th scope="col">Телефон</th>
                @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'manager']))
                    <th scope="col" data-sort-method="none">Действия</th>
                @endif
            </tr>
            </thead>
          <tbody>
            @foreach($stores as $store)
                @include('admin.stores.table')
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endsection
