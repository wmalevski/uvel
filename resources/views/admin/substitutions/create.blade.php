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
                    <select name="user_id" class="form-control" data-search="/ajax/select_search/users/">
                        <option value="">Избери потребител</option>
                    </select>
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Магазин: </label>
                    <select name="store_id" class="form-control" data-search="/ajax/select_search/stores/">
                        <option value="">Избери магазин</option>
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
                        <input name="dateTo" type="text" class="form-control bdc-grey-200 end-date" placeholder="Избери дата" data-provide="datepicker" data-date-autoclose="true" value="{{ Carbon\Carbon::parse(Carbon\Carbon::now()->addDay())->format('d-m-Y')}}" data-date-format="dd-mm-yyyy" data-date-start-date="{{ Carbon\Carbon::parse(Carbon\Carbon::now()->addDay())->format('d-m-Y')}}">
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