@extends('admin.layout')

@section('content')
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавяне на разход</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="expenses" data-type="add" action="expenses" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont"></div>
                    {{ csrf_field() }}

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                                <input id="send_to_store" data-transfer="transfer-to-shop" type="checkbox" name="send_to_store">
                                <label for="send_to_store" class="peers peer-greed js-sb ai-c">
                                    <span class="peer peer-greed">Трансфер</span>
                                </label>
                            </div>
                            @if(\Illuminate\Support\Facades\Auth::user()->role =='admin')
                                <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                                    <input id="send_to_bank" data-transfer="transfer-to-bank" type="checkbox"
                                           name="send_to_bank">
                                    <label for="send_to_bank" class="peers peer-greed js-sb ai-c">
                                        <span class="peer peer-greed">Трансфер към банка</span>
                                    </label>
                                </div>
                            @endif

                            <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                                <input id="expense"  data-transfer type="checkbox" name="expense">
                                <label for="expense" class="peers peer-greed js-sb ai-c">
                                    <span class="peer peer-greed">Разход</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row" data-transferTarget="transfer-to-shop" style="display: none;">
                        <div class="form-group col-md-12">
							<label>От магазин:</label>
							<div class="input-group">
								<input type="text" class="form-control" placeholder="{{ $current_store->location }} - {{ $current_store->name }}" disabled>
							</div>
						</div>

						<div class="form-group col-md-12">
							<label>До магазин:</label>
							<select name="store_id" class="store-select form-control" data-search="/ajax/select_search/stores/">
								<option value="">Избери магазин</option>
							</select>
						</div>

						<div class="col-12">
							<hr>
						</div>
					</div>

                    <div class="form-row" data-transferTarget="transfer-to-bank" style="display: none;">
                        <div class="form-group col-md-12">
							<label>От магазин:</label>
							<div class="input-group">
								<input type="text" class="form-control" placeholder="{{ $current_store->location }} - {{ $current_store->name }}" disabled>
							</div>
						</div>

						<div class="form-group col-md-12">
							<label>До банка:</label>
							<select name="bank_id" class="store-select form-control">
								<option value="0">Избери</option>
							</select>
						</div>

						<div class="col-12">
							<hr>
						</div>
					</div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="type">Основание:</label>
                            <select id="type" name="type_id" class="form-control" data-calculatePayment-currency>
                                <option value="">Избери</option>
                                @foreach($expenses_types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="expense_amount">Сума: </label>
                            <input type="number" class="form-control" id="expense_amount" name="expense_amount" placeholder="Сума:">
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
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editExpense" role="dialog" aria-labelledby="editExpense"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Разходи <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-form-type="add" data-form="expenses">Добави</button></h4>
      <p>Преглед на въведените разходи.</p>
      <table id="main_table" class="table">
        <thead>
          <tr>
            <th scope="col">Основание</th> 
            <th scope="col">Сума</th> 
            <th scope="col">Магазин </th> 
            <th scope="col">Валута</th> 
            <th scope="col">Пояснение</th>
              @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                <th scope="col" data-sort-method="none">Действия</th>
              @endif
          </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
                @include('admin.expenses.table')
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
