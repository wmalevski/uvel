@extends('admin.layout')

@section('content')


<div class="modal fade edit--modal_holder" id="editSubstitution" role="dialog" aria-labelledby="editSubstitution" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>

<div class="modal fade" id="userSubstitution" role="dialog" aria-labelledby="editUserSubstitution" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="editModalWrapper">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserLabel">Заместване в друг обект</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
            
            <form method="POST" name="substitutions" data-type="add" action="users/substitutions">
                <div class="modal-body">    
                  <div class="info-cont">
                  </div>
          
                  {{ csrf_field() }}

                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Потребител: </label>
                            <select name="user" class="form-control">
                                <option value="">Избери потребител</option>
                        
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->store }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                  </div>
        
                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Магазин: </label>
                            <select name="store" class="form-control">
                                <option value="">Избер магазин</option>
                        
                                @foreach($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }} - {{ $store->location }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                  </div>
        
                  <div class="row">
                    <div class="col-md-6">
                        <label class="fw-500">Дата от</label>
                        <div class="timepicker-input input-icon form-group">
                            <div class="input-group">
                                <div class="input-group-addon bgc-white bd bdwR-0">
                                    <i class="ti-calendar"></i>
                                </div>
                                <input type="text" name="dateFrom" class="form-control bdc-grey-200 start-date" placeholder="Избери дата" data-provide="datepicker" data-date-autoclose="true" value="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" data-date-format="dd-mm-yyyy">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-500">Дата до</label>
                        <div class="timepicker-input input-icon form-group">
                            <div class="input-group">
                                <div class="input-group-addon bgc-white bd bdwR-0">
                                    <i class="ti-calendar"></i>
                                </div>
                                <input name="dateTo" type="text" class="form-control bdc-grey-200 end-date" placeholder="Избери дата" data-provide="datepicker" data-date-autoclose="true" value="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" data-date-format="dd-mm-yyyy">
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="sendUserForm" data-state="add_state" class="add-btn-modal btn btn-primary">Изпрати</button>
                  </div>
              </form>
        </div>
      </div>
    </div>
  </div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Замествания <button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="substitutions" data-toggle="modal" data-target="#userSubstitution">Изпрати</button></h4>
        <p>Преглед на текущи замествания.</p>
        <table id="user-substitute-active" class="table active">
          <thead>
            <tr>
              <th scope="col">Потребител</th> 
              <th scope="col">Магазин</th>
              <th scope="col">Дата от</th>
              <th scope="col">Дата до</th>
              <th scope="col">Действия</th>
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
        <table id="user-substitute-inactive" class="table inactive">
          <thead>
            <tr>
              <th scope="col">Потребител</th> 
              <th scope="col">Магазин</th>
              <th scope="col">Дата от</th>
              <th scope="col">Дата до</th>
              <th scope="col">Действия</th>
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