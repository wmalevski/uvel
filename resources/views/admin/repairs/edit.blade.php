<div class="modal-header">
    <h5 class="modal-title" id="addRepairLabel">Добавяне на артикул за ремонт</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form method="POST" action="/repairs" name="addRepair">
    <input name="_method" type="hidden" value="PUT">
    <div class="modal-body">    
        <div class="info-cont">
        </div>

        {{ csrf_field() }}  
                    
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Име</label>
                <input type="text" class="form-control" name="customer_name" value="{{ $repair->customer_name }}" placeholder="Име на клиент">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Телефон</label>
                <input type="text" class="form-control" name="customer_phone" value="{{ $repair->customer_phone }}" placeholder="Телефон на клиента">
            </div>
        </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCity">Приемане</label>
                    <div class="timepicker-input input-icon form-group">
                        <div class="input-group">
                            <div class="input-group-addon bgc-white bd bdwR-0">
                                <i class="ti-calendar"></i>
                            </div>
                        <input readonly type="text" value="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" class="form-control bdc-grey-200 start-date" name="date_recieved" placeholder="Дата на приемане" data-date-format="dd-mm-yyyy" data-provide="datepicker" data-clear="false">
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputZip">Срок</label>
                    <div class="timepicker-input input-icon form-group">
                        <div class="input-group">
                            <div class="input-group-addon bgc-white bd bdwR-0">
                                <i class="ti-calendar"></i>
                            </div>
                            <input type="text" data-date-format="dd-mm-yyyy" name="date_returned" class="form-control bdc-grey-200 start-date" placeholder="Дата на връщане" data-provide="datepicker" value="{{ $repair->date_returned }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea class="form-control" name="repair_description">{{ $repair->repair_description }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Тип ремонт</label>
                    <select name="type" class="form-control fill-field" data-fieldToFill="input[name='price']">
                        <option value="">Избери</option>

                        @foreach($repairTypes as $repairType)
                            <option value="{{ $repairType->id }}" data-price="{{ $repairType->price }}">{{ $repairType->name }} - {{ $repairType->price }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Тегло</label>
                    <input type="text" class="form-control" name="weight" value="{{ $repair->weight }}" placeholder="Тегло на артикула">
                </div>

                <div class="form-group col-md-6">
                    <label for="inputPassword4">Карати</label>
                    <input type="text" class="form-control" name="carates" value="{{ $repair->weight }}" placeholder="Карати">
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Цена</label>
                    <input type="text" class="form-control" name="price" value="{{ $repair->price }}" placeholder="Цена на ремонта">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Капаро</label>
                    <input type="text" class="form-control" name="deposit" value="{{ $repair->deposit }}" placeholder="Оставено капаро">
                </div>
            </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="finish" class="btn btn-primary">Приключи</button>
        <button type="submit" id="edit" class="btn btn-primary">Промени</button>
    </div>
</form>