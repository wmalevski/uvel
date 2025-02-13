@extends('admin.layout')

@section('content')
<div class="modal fade add--modal_holder" id="addIncome" role="dialog" aria-labelledby="addIncomeLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
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
	  <h4 class="c-grey-900 mB-20">Приходи 
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
            <button data-url="income/create" type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="income"
            data-toggle="modal" data-target="#addIncome">
            Добави
            </button>
        @endif
      </h4>
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
  {{ $income->links() }}
  </div>
</div>
@endsection