<div class="addModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="addDiscountLabel">Добавяне на отстъпка</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="POST" name="discounts" data-type="add" action="discounts" autocomplete="off">
        <div class="modal-body">
            <div class="info-cont">
            </div>
            {{ csrf_field() }}
            <div id="success-container"></div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="1">Отстъпка:</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="1" name="discount" placeholder="Процент отстъпка: " min="0" max="100">
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
                            <input type="text" name="date_expires" class="form-control bdc-grey-200 start-date" placeholder="Валидна до:" data-date-autoclose="true" data-provide="datepicker" data-date-format="dd-mm-yyyy" data-date-start-date="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}">
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="form-group">
                <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                    <input type="checkbox" id="lifetime_add" name="lifetime" class="peer">
                    <label for="lifetime_add" class="peers peer-greed js-sb ai-c">
                        <span class="peer peer-greed">Безсрочна</span>
                    </label>
                </div>
            </div>
    
            <div class="form-group">
                <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                    <input type="checkbox" id="global_discountcode" name="global_discountcode" class="peer">
                    <label for="global_discountcode" class="peers peer-greed js-sb ai-c">
                        <span class="peer peer-greed">Глобален промокод</span>
                    </label>
                </div>
            </div>
    
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="2">Потребител: </label>
                    <select name="user_id" class="form-control" data-search="/ajax/select_search/users/" multiple>
                        <option></option>
                    </select>
                    <input type="hidden" name="user_list" value="">
                </div>
            </div>
    
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="2">Група: </label>
                    <select name="group_id" class="form-control" data-search="/ajax/select_search/groups/">
                        <option value="">Избери</option>
                    </select>
                </div>
            </div>
    
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="barcode">Баркод: </label>
                    <input type="text" class="form-control"  name="barcode" placeholder="Добави баркод">
                </div>
            </div>
            <div id="errors-container"></div>
        </div>
    
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="add" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
        </div>
    </form>
</div>