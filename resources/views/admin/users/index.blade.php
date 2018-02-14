@extends('admin.layout')

@section('content')

<div class="modal fade" id="editUser"   role="dialog" aria-labelledby="editUser"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Потребители</h4>
        <p>Преглед на потребителите.</p>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Име</th> 
              <th scope="col">Email</th>
              <th scope="col">Вид</th>
              <th scope="col">Магазин</th>
              <th scope="col">Действия</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              @include('admin.users.table')
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endsection