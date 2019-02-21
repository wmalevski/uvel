@extends('admin.layout')

@section('content')

<div class="modal fade" id="addUser" role="dialog" aria-labelledby="addUser"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserLabel">Добавяне на потребител</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="users" name="users" data-type="add" autocomplete="off">
                 
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}  
                                
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="name-1" name="name" placeholder="Име на потребител:">
                    </div>

                    <div class="form-group">
                        <label for="1">Email: </label>
                        <input type="email" class="form-control" id="email-1" name="email" placeholder="Имейл на потребител:">
                    </div>

                    <div class="form-group">
                        <label for="1">Парола: </label>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Парола:" required>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">Повтори парола: </label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Повтори паролата:" required>
                    </div>
                
                    <div class="form-group">
                        <label>Роля: </label>
                        <select name="role" class="form-control">
                            <option value="">Избери роля</option>
                    
                            @foreach(Bouncer::role()->all() as $role)
                                <option value="{{ $role->name }}">{{ $role->title }}</option>
                            @endforeach
                        </select>
                    </div>
          
                    <div class="form-group">
                        <label>Магазин: </label>
                        <select name="store_id" class="form-control" data-search="/ajax/select_search/stores/">
                            <option value="">Избери магазин</option>
                        </select>
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

<div class="modal fade edit--modal_holder" id="editUser" role="dialog" aria-labelledby="editUser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
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
        <h4 class="c-grey-900 mB-20">Потребители <button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="users" data-toggle="modal" data-target="#addUser">Добави</button></h4>
        <p>Преглед на потребителите.</p>
        <table class="table tablesort">
          <thead>
            <tr>
              <th scope="col">Име</th> 
              <th data-sort-method="none" scope="col">Email</th>
              <th scope="col">Вид</th>
              <th scope="col">Магазин</th>
              <th data-sort-method="none" scope="col">Действия</th>
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
