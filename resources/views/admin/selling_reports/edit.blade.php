@extends('admin.layout')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mB-20"> Експорт </h4>
                <p>Преглед на продажби в <strong>{{ $store->name }} - {{ $store->location }}</strong>.</p>
                <div class="row" data-filter="reports" data-report-key="sellingreportsexport">
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
                <table id="main_table" class="table" data-store-id="{{$store->id}}">
                    <thead>
                    <tr>
                        <th scope="col">Артикул</th>
                        <th scope="col">Продажба</th>
                        <th scope="col">Стойност</th>
                        <th scope="col">Отстъпка</th>
                        <th scope="col">След отстъпка</th>
                        <th scope="col">С карта/кеш</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Служител</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            @foreach($products as $product)
                                @if($product->id == $payment->product_id)
                                    @include('admin.selling_reports.table_edit')
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection