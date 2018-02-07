@extends('admin.layout')

@section('content')

<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUser"
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
              <th scope="col">Вид</th>
              <th scope="col">Магазин</th>
              <th scope="col">Действия</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
                <tr>
                    <td></td>
                    <td>{{ $user->name }}</td> 
                    <td>{{ $user->roles->first()['display_name'] }}</td>
                    <td>@if($user->store != '') {{ App\Stores::find($user->store)->name }} @endif</td> 
                    <td><a href="users/{{$user->id}}" class="edit-btn" data-toggle="modal" data-target="#editUser"><i class="c-brown-500 ti-pencil"></i></a></td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endsection