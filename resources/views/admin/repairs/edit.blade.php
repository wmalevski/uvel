<div class="editModalWrapper">
<div class="modal-header">
    <h5 class="modal-title" id="fullEditRepairLabel">Редактиране на артикул за ремонт</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form method="POST" action="repairs/{{ $repair->barcode }}" name="repairs" data-type="edit">
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
                        <input readonly type="text" value="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" class="form-control bdc-grey-200 start-date" name="date_recieved" placeholder="Дата на приемане" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-clear="false">
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
                            <input type="text" data-date-format="dd-mm-yyyy" name="date_returned" class="form-control bdc-grey-200 start-date" placeholder="Дата на връщане" data-date-autoclose="true" data-provide="datepicker" value="{{ $repair->date_returned }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea class="form-control" name="repair_description">{{ $repair->repair_description }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Тип ремонт</label>
                    <select name="type_id" class="form-control fill-field" data-fieldToFill="input[name='price']" data-repair-type>
                        <option value="">Избери</option>

                        @foreach($repairTypes as $repairType)
                            <option value="{{ $repairType->id }}" data-price="{{ $repairType->price }}" @if($repair->type->id == $repairType->id) selected @endif>{{ $repairType->name }} - {{ $repairType->price }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>Материал: </label>
                    <select name="material_id" class="form-control">
                        <option value="">Избер материал</option>
                
                        @foreach($materials as $material)
                            @if($material->pricesSell->first())
                                <option value="{{ $material->id }}" @if($repair->material_id == $material->id) selected @endif>@if($material->parent) {{ $material->parent->name }} @endif - {{ $material->color }} - {{ $material->code }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Тегло</label>
                    <input type="number" class="form-control" name="weight" value="{{ $repair->weight }}" placeholder="Тегло на артикула" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="inputPassword4">Тегло след ремонта</label>
                    <input type="number" class="form-control" name="weight_after" value="{{ $repair->weight_after }}" placeholder="Тегло на артикула след ремонта">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Цена</label>
                    <input type="number" class="form-control" name="price" value="{{ $repair->price }}" placeholder="Цена на ремонта" data-repair-price readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Цена след ремонта</label>
                    <input type="number" class="form-control" name="price_after" value="{{ $repair->price_after }}" placeholder="Цена на ремонта">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-5">
                    <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                        <input type="checkbox" id="inputCall1" name="status" class="peer" value="done">
                        <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                            <span class="peer peer-greed">Готов за връщане</span>
                        </label>
                    </div>
                </div>
            </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="edit" class="edit-btn-modal btn btn-primary">Промени</button>
    </div>
</form>
</div>