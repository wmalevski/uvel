<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="fullExpenseLabel">Промени по разход</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <form method="POST" data-type="edit" name="expenses" action="expenses/{{ $expense->id }}">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">    
                <div class="info-cont">
                </div>
            {{ csrf_field() }}
    
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="type">Основание: </label>
                    <select id="type" name="type_id" class="form-control" data-calculatePayment-currency>
                        @foreach($expenses_types as $type)
                            <option value="{{ $type->id }}" @if($type->id == $expense->type_id) selected @endif">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="amount">Сума: </label>
                    <input type="number" class="form-control" id="amount" value="{{ $expense->amount }}" name="amount" placeholder="Сума:">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="currency_id">Валута: </label>
                    <select id="currency_id" name="currency_id" class="form-control" data-calculatePayment-currency>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}" data-default="{{$currency->default }}" data-currency="{{ $currency->currency }}" @if($currency->id == $expense->currency_id) selected @endif >{{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="additional_info">Пояснение: </label>
                    <textarea class="form-control" id="additional_info" name="additional_info" placeholder="Кратко пояснение">{{ $expense->additional_info }}</textarea>
                </div>
            </div>
        </div>
    
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
</div>
