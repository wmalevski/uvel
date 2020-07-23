@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mB-20"> Продукти на път </h4>
                <p>Преглед на продуктите на път.</p>

                <div class="row" data-filter="reports" data-report-key="productstravellingreports">
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
                        <th scope="col">Артикул</th>
                        <th scope="col">ОТ Магазин</th>
                        <th scope="col">Изпратен Дата/Час</th>
                        <th scope="col">Служител</th>
                        <th scope="col">ДО Магазин</th>
                        <th scope="col">Приет Дата/Час</th>
                        <th scope="col">Служител</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products_travellings as $products_travelling)
                        @include('admin.reports.productstravelling_reports.table')
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
