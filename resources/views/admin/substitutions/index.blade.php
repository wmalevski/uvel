@extends('admin.layout')

@section('content')


<div class="modal fade edit--modal_holder" id="editSubstitution" role="dialog" aria-labelledby="editSubstitution" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<div class="modal fade add--modal_holder" id="userSubstitution" role="dialog" aria-labelledby="editUserSubstitution" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      </div>
    </div>
  </div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Замествания <button data-url="users/substitutions/create" type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="substitutions" data-toggle="modal" data-target="#userSubstitution">Изпрати</button></h4>
        <p>Преглед на текущи замествания.</p>
        <table id="user-substitute-active" class="table active table-fixed">
          <thead>
            <tr>
              <th scope="col">Потребител</th>
              <th scope="col">Магазин</th>
              <th scope="col">Дата от</th>
              <th scope="col">Дата до</th>
                @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                    <th scope="col" data-sort-method="none">Действия</th>
                @endif
            </tr>
          </thead>
          <tbody>
            @foreach($activeSubstitutions as $substitution)
                @include('admin.substitutions.table')
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  

  <div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <p>История на заместванията</p>
        <table id="user-substitute-inactive" class="table inactive table-fixed">
          <thead>
            <tr>
              <th scope="col">Потребител</th>
              <th scope="col">Магазин</th>
              <th scope="col">Дата от</th>
              <th scope="col">Дата до</th>
                @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                    <th scope="col">Действия</th>
                @endif
            </tr>
          </thead>
          <tbody>
            @foreach($inactiveSubstitutions as $substitution)
                @include('admin.substitutions.table')
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endsection
