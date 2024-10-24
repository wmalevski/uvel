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
                    <div class="timepicker-input input-icon form-group date-recieved">
                        <div class="input-group">
                            <div class="input-group-addon bgc-white bd bdwR-0">
                                <i class="ti-calendar"></i>
                            </div>
                        <input readonly type="text" value="{{ $repair->date_recieved }}" class="form-control bdc-grey-200 start-date" name="date_recieved" placeholder="Дата на приемане" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-clear="false">
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputZip">Срок</label>
                    <div class="timepicker-input input-icon form-group date-returned">
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
                    <select name="type_id" class="form-control fill-field" data-fieldToFill="input[name='price']" data-repair-type data-search="/ajax/select_search/repairtypes/">
                        <option value="">Избери</option>

                        @foreach($repairTypes as $repairType)
                            <option value="{{ $repairType->id }}" data-price="{{ $repairType->price }}" @if($repair->type->id == $repairType->id) selected @endif>{{ $repairType->name }} - {{ $repairType->price }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>Материал: </label>
                    <select name="material_id" class="form-control" data-repair-material data-search="/ajax/select_search/global/materials/">
                        <option value="">Избери материал</option>

                        @foreach($materials as $material)
                            @if($material->pricesSell->first())
                                <option data-price="{{ $material->pricesBuy->first()->price }}" value="{{ $material->id }}" @if($repair->material_id == $material->id) selected @endif>@if($material->parent) {{ $material->parent->name }} @endif - {{ $material->color }} - {{ $material->code }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Тегло</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="weight" value="{{ $repair->weight }}" placeholder="Тегло на артикула" data-repair-weightBefore readonly>
                        <span class="input-group-addon">гр.</span>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="inputPassword4">Тегло след ремонта</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="weight_after" data-repair-weightAfter @if($repair->weight_after == '') value="{{ $repair->weight }}" @else value="{{ $repair->weight_after }}" @endif  placeholder="Тегло на артикула след ремонта">
                        <span class="input-group-addon">гр.</span>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Цена</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="price" value="{{ $repair->price }}" placeholder="Цена на ремонта" data-repair-price readonly>
                        <span class="input-group-addon">лв</span>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Цена след ремонта</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="price_after" data-repair-priceAfter
                        value="{{ ($repair->price_after == '' ? $repair->price : $repair->price_after) }}" placeholder="Цена на ремонта">
                        <span class="input-group-addon">лв</span>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="prepaid">Капаро</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="prepaid" value="{{$repair->prepaid}}" min=0 disabled/>
                        <span class="input-group-addon">лв</span>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="remainder">Остатък</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="remainder" value="{{ ($repair->price_after == '' ? $repair->price : $repair->price_after) - $repair->prepaid }}" disabled />
                        <span class="input-group-addon">лв</span>
                    </div>
                </div>
            </div>

        @if ($repair->status == "done" || $repair->status  == 'repairing' || $repair->status == "returning")
            <div class="form-row">
                <div class="form-group col-md-5">
                    <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                        <input type="checkbox" id="done" name="status" class="peer" value="done" @if($repair->status == 'done') checked @endif>
                        <label for="done" class="peers peer-greed js-sb ai-c">
                            <span class="peer peer-greed">Готов за връщане</span>
                        </label>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        @if ($repair->status == "done" || $repair->status  == 'repairing' || $repair->status == "returning")
            <button type="submit" id="edit" class="edit-btn-modal btn btn-primary">Промени</button>
        @endif
    </div>
</form>
</div>