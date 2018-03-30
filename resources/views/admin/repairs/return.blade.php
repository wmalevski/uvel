<div class="modal-header">
    <h5 class="modal-title" id="scanRepairLabel">Връщане на ремонтиран артикул</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form method="POST" action="/repairs/return" name="scanRepair">
     
    <div class="modal-body">    
        <div class="info-cont">
        </div>

        {{ csrf_field() }}  
                    

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">Баркод</label>
                <input type="text" class="form-control" name="barcode" placeholder="Моля сканирайте баркода за артикула">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Име</label>
                <input type="text" class="form-control" name="customer_name" placeholder="Име на клиент">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Телефон</label>
                <input type="text" class="form-control" name="customer_phone" placeholder="Телефон на клиента">
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
                        <input type="text" value="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" class="form-control bdc-grey-200 start-date" name="date_recieved" placeholder="Дата на приемане" data-date-format="dd-mm-yyyy" data-provide="datepicker">
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
                            <input type="text" data-date-format="dd-mm-yyyy" name="date_returned" class="form-control bdc-grey-200 start-date" placeholder="Дата на връщане" data-provide="datepicker">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea class="form-control" name="repair_description"></textarea>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Тип ремонт</label>
                    <select name="type" class="form-control">
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
                    <input type="text" class="form-control" name="weight" placeholder="Тегло на артикула">
                </div>

                <div class="form-group col-md-6">
                    <label for="inputPassword4">Карати</label>
                    <input type="text" class="form-control" name="carates" placeholder="Карати">
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Цена</label>
                    <input type="text" class="form-control" name="prize" placeholder="Цена на ремонта">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Капаро</label>
                    <input type="text" class="form-control" name="deposit" placeholder="Оставено капаро">
                </div>
            </div>

            <div class="form-group">
                <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                    <input type="checkbox" id="inputCall2" name="inputCheckboxesCall" class="peer">
                    <label for="inputCall2" class="peers peer-greed js-sb ai-c">
                        <span class="peer peer-greed">Фискален</span>
                    </label>
                </div>

                <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                    <input type="checkbox" id="inputCall2" name="inputCheckboxesCall" class="peer">
                    <label for="inputCall2" class="peers peer-greed js-sb ai-c">
                        <span class="peer peer-greed">Без</span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Плащане</button>
                <button type="submit" class="btn btn-primary">Ръчно пускане на фискален бон</button>
            </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="add" class="btn btn-primary">Върни</button>
    </div>
</form>