@extends('admin.layout')

@section('content')
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
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
	</div>
</div>

<div class="modal fade edit--modal_holder" id="editIncome" role="dialog" aria-labelledby="editIncome"
aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content"></div>
	</div>
</div>

<div class="row">
  <div class="col-md-12">
	<div class="bgc-white bd bdrs-3 p-20 mB-20">
	  <h4 class="c-grey-900 mB-20">Приходи <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-form-type="add" data-form="income">Добави</button></h4>
	  <p>Преглед на въведените Приходи.</p>

	  <div class="row" data-filter="reports" data-report-key="income">
		<div class="col-md-5">
			<div class="timepicker-input input-icon form-group">
				<div class="input-group">
					<div class="input-group-addon bgc-white bd bdwR-0">
						<i class="ti-calendar"></i>
					</div>

					<input type="text" name="date_from" class="form-control bdc-grey-200 start-date"
							placeholder="От дата: " data-date-autoclose="true" data-provide="datepicker" data-date-format="yyyy-mm-dd" />
				</div>
			</div>
			</div>

		<div class="col-md-5">
			<div class="timepicker-input input-icon form-group">
				<div class="input-group">
					<div class="input-group-addon bgc-white bd bdwR-0">
						<i class="ti-calendar"></i>
					</div>

					<input type="text" name="date_to" class="form-control bdc-grey-200 end-date"
							placeholder="До дата: " data-date-autoclose="true" data-provide="datepicker" data-date-format="yyyy-mm-dd"/>
				</div>
			</div>
		</div>

		<div class="col-md-2">
			<button type="button" id="filter-reports" class="btn btn-primary add-btn-modal">Филтрирай</button>
		</div>
	</div>

	  <table id="main_table" class="table">
		<thead>
		  <tr>
			<th scope="col">Основание</th>
			<th scope="col">Сума</th>
			<th scope="col">Магазин</th>
			<th scope="col">Валута</th>
			<th scope="col">Пояснение</th>
			  @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
				<th scope="col" data-sort-method="none">Действия</th>
			  @endif
		  </tr>
		</thead>
		<tbody>
			@foreach($income as $inc)
				@include('admin.income.table')
			@endforeach
		</tbody>
	  </table>
	</div>
  </div>
</div>
@endsection