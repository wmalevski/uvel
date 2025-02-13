@extends('admin.layout')

@section('content')

<div class="modal fade add--modal_holder" id="addStore" role="dialog" aria-labelledby="addStore">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editStore" tabindex="-1"  role="dialog" aria-labelledby="editStore">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Магазини
            @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                <button data-url="stores/create" type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="stores"
                data-toggle="modal" data-target="#addStore">
                Добави
                </button>
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
