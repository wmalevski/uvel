@extends('admin.layout')

@section('content')
<div class="modal fade add--modal_holder" id="addExpense" role="dialog" aria-labelledby="addExpenseLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editExpense" role="dialog" aria-labelledby="editExpense">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Разходи <button data-url="expenses/create" type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#addExpense" data-form-type="add" data-form="expenses">Добави</button></h4>
      <p>Преглед на въведените разходи.</p>

      <div class="row" data-filter="reports" data-report-key="expenses">
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
            <th scope="col">От магазин </th>
            <th scope="col">До магазин </th>
            <th scope="col">Валута</th>
            <th scope="col">Дата</th>
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
    {{ $expenses->links() }}
  </div>
</div>
@endsection
