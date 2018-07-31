<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="editUserLabel">Заместване в друг обект</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    
    <form method="POST" name="sendUser" action="users/substitutions/{{ $substitution->id }}">
        <input name="_method" type="hidden" value="PUT">
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
                            <option value="{{ $user->id }}" @if($substitution->user_id == $user->id) selected @endif>{{ $user->name }} - {{ $user->store }}</option>
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
                            <option value="{{ $store->id }}" @if($substitution->store_id == $store->id) selected @endif>{{ $store->name }} - {{ $store->location }}</option>
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
                        <input type="text" name="dateFrom" class="form-control bdc-grey-200 start-date" placeholder="Избери дата" data-provide="datepicker" data-date-autoclose="true" value="{{ Carbon\Carbon::parse($substitution->date_from)->format('d-m-Y')}}" data-date-format="dd-mm-yyyy">
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
                        <input name="dateTo" type="text" class="form-control bdc-grey-200 end-date" placeholder="Избери дата" data-provide="datepicker" data-date-autoclose="true" value="{{ Carbon\Carbon::parse($substitution->date_to)->format('d-m-Y')}}" data-date-format="dd-mm-yyyy">
                    </div>
                </div>
            </div>
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="sendUserForm" class="edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
</div>