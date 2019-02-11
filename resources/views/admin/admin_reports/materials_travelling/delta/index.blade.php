@extends('admin.layout')

@section('content')
<div class="modal fade" id="exportModal" role="dialog" aria-labelledby="export"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullEditRepairLabel">Експорт таблица</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/pickurl" name="exportAdminReport" data-type="export"> 
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>

                    {{ csrf_field() }}  
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="">От</label>
                            <div class="timepicker-input input-icon">
                                <div class="input-group">
                                    <div class="input-group-addon bgc-white bd bdwR-0">
                                        <i class="ti-calendar"></i>
                                    </div>
                                    <input id="export_from" type="text" data-date-autoclose="true" data-date-format="dd-mm-yyyy" class="form-control bdc-grey-200 not-clear" name="export_from" placeholder="Избери дата от">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">До</label>
                            <div class="timepicker-input input-icon">
                                <div class="input-group">
                                    <div class="input-group-addon bgc-white bd bdwR-0">
                                        <i class="ti-calendar"></i>
                                    </div>
                                    <input id="export_to" type="text" data-date-autoclose="true" data-date-format="dd-mm-yyyy" class="form-control bdc-grey-200" name="export_to" placeholder="Избери дата до">
                                </div>
                            </div>
                        </div>
                    </div>      
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" class="btn btn-primary">Експорт</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row admin-reports-row">
    <div class="col-md-12">
        <h3>Таблица делта</h3>
    </div>
    <div class="col-md-12">
        <form name="adminReport" data-url="/#">
            <div class="row">
                <div class="col-md-4">
                    <label for="">От</label>
                    <div class="timepicker-input input-icon">
                        <div class="input-group">
                            <div class="input-group-addon bgc-white bd bdwR-0">
                                <i class="ti-calendar"></i>
                            </div>
                            <input id="report_from" type="text" data-date-autoclose="true" data-date-format="dd-mm-yyyy" class="form-control bdc-grey-200 not-clear" name="date_from" placeholder="Избери дата от">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="">До</label>
                    <div class="timepicker-input input-icon">
                        <div class="input-group">
                            <div class="input-group-addon bgc-white bd bdwR-0">
                                <i class="ti-calendar"></i>
                            </div>
                            <input id="report_to" type="text" data-date-autoclose="true" data-date-format="dd-mm-yyyy" class="form-control bdc-grey-200" name="date_to" placeholder="Избери дата до">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="btn_container">
                        <button type="submit" class="btn btn-primary">Генерирай</button>
                        <button type="button" class="btn btn-primary" data-form-type="export" data-form="exportAdminReport" data-toggle="modal" data-target="#exportModal">Експорт</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed tablesort">
            <thead>
                <tr>
                    <th>Материал</th>
                    <th>Изпратено</th>
                    <th>Прието</th>
                    <th>Разлика</th>
                    <th>От Магазин</th>
                    <th>Изпратен Дата/час</th>
                    <th>Служител</th>
                    <th>До Магазин</th>
                    <th>Прието Дата/час</th>
                    <th>Служител</th>
                </tr>
            </thead>
            <tbody>
                <td>Материал 1</td>
                <td>12</td>
                <td>11.5</td>
                <td>0.5</td>
                <td>София</td>
                <td>10.02.2018 10:30</td>
                <td>Жоро</td>
                <td>Пловдив</td>
                <td>11.02.2018 9:38</td>
                <td>Атанас</td>
            </tbody>
        </table>
    </div>
</div>
@endsection