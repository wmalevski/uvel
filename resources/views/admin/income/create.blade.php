<div class="incomeAddWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Добавяне на Приход</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <form method="POST" name="income" data-type="add" action="income" autocomplete="off">
        <div class="modal-body">
            <div class="info-cont"></div>
            {{ csrf_field() }}
    
            <div class="form-row" style="display: none;">
                <div class="form-group col-md-12">
                    <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                        <input id="income"  data-transfer type="checkbox" name="income" checked="checked">
                        <label for="income" class="peers peer-greed js-sb ai-c">
                            <span class="peer peer-greed">Приход</span>
                        </label>
                    </div>
                </div>
            </div>
    
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="type">Основание:</label>
                    <select id="type" name="type_id" class="form-control" data-calculatePayment-currency>
                        <option value="">Избери</option>
                        @foreach($income_types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
    
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="income_amount">Сума: </label>
                    <input type="number" class="form-control" id="income_amount" name="income_amount" placeholder="Сума:" min=1>
                </div>
            </div>
    
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="currency_id">Валута: </label>
                    <select id="currency_id" name="currency_id" class="form-control" data-calculatePayment-currency>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}" data-default="{{$currency->default }}" data-currency="{{ $currency->currency }}" @if($currency->default == "yes") selected @endif >{{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
    
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="additional_info">Пояснение: </label>
                    <textarea class="form-control" id="additional_info" name="additional_info" placeholder="Кратко пояснение"></textarea>
                </div>
            </div>
        </div>
    
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
        </div>
    </form>
</div>