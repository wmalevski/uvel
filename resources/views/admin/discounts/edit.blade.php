<div class="editModalWrapper">
<div class="modal-header">
    <h5 class="modal-title" id="editDiscountLabel">Промяна на отстъпка</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form method="POST" name="discounts" data-type="edit" action="discounts/{{ $discount->id }}">
    <input name="_method" type="hidden" value="PUT">
    <div class="modal-body">
        <div class="info-cont">
            </div>
            {{ csrf_field() }}
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="1">Отстъпка: </label>
                <div class="input-group">
                    <input type="text" class="form-control" id="1" name="discount" value="{{ $discount->discount }}" placeholder="Процент отстъпка: " min="0" max="100">
                    <span class="input-group-addon">%</span>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label for="inputZip">Валидна до</label>
                <div class="timepicker-input input-icon form-group">
                    <div class="input-group">
                        <div class="input-group-addon bgc-white bd bdwR-0">
                            <i class="ti-calendar"></i>
                        </div>
                        <input type="text" name="date_expires" value="{{ $discount->expires }}" class="form-control bdc-grey-200 start-date"
                               placeholder="Валидна до: " data-date-autoclose="true" data-provide="datepicker" data-date-format="dd-mm-yyyy"
                               data-date-start-date="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}"
                               @if($discount->lifetime == 'yes') readonly @endif>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                <input type="checkbox" id="lifetime_edit" name="lifetime" class="peer" @if($discount->lifetime == 'yes') checked @endif>
                <label for="lifetime_edit" class="peers peer-greed js-sb ai-c">
                    <span class="peer peer-greed">Безсрочна</span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                <input type="checkbox" id="active" name="active" class="peer" @if($discount->active == 'yes') checked @endif>
                <label for="active" class="peers peer-greed js-sb ai-c">
                    <span class="peer peer-greed">Активна</span>
                </label>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="2">Потребител: </label>
                <select name="user_id" class="form-control">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @if($discount->user_id) @if($discount->user_id == $user->id) selected @endif @endif>{{ $user->email }} - {{ $user->store->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="barcode">Баркод: </label>
                <input type="text" class="form-control"  name="barcode"  value="{{ $discount->barcode }}">
            </div>
        </div>
        <div id="errors-container"></div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="edit" data-state="edit_state" class="action--state_button btn btn-primary">Промени</button>
    </div>
</form>
</div>
