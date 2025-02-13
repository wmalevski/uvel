@extends('admin.layout')

@section('content')

<div class="modal fade add--modal_holder" id="addUser" role="dialog" aria-labelledby="addUser">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editUser" role="dialog" aria-labelledby="editUser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<div class="modal fade" id="userSubstitution" role="dialog" aria-labelledby="editUserSubstitution" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Потребители
            @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                <button data-url="users/create" type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="users" data-toggle="modal" data-target="#addUser">Добави</button>
            @endif
        </h4>
        <p>Преглед на потребителите.</p>
        <table id="main_table" class="table tablesort table-fixed">
          <thead>
            <tr data-sort-method="thead">
              <th scope="col">Потребител</th>
              <th scope="col">Вид</th>
              <th scope="col">Магазин</th>
                @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                    <th data-sort-method="none" scope="col">Действия</th>
                @endif
            </tr>
            
            <tr class="search-inputs" data-dynamic-search-url="ajax/search/users/">
                <th>
                    <input class="filter-input form-control" name="search" type="text" data-dynamic-search-param="byEmail=" placeholder="Имейл/Име">
                </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              @include('admin.users.table')
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $users->links() }}
    </div>
  </div>
  @endsection
