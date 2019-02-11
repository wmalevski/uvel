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
        <h3>Агрегирана информация за справките по магазин</h3>
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
                    <th>Магазин</th>
                    <th>Дата</th>
                    <th>Каса лв.</th>
                    <th>Каса EUR</th>
                    <th>Каса USD</th>
                    <th>Бижута лв.</th>
                    <th>Бижута брой</th>
                    <th>Правилно подаден</th>
                </tr>
            </thead>
            <tbody>
                <td>1</td>
                <td>15.12.2018</td>
                <td>23,545</td>
                <td>356</td>
                <td>122</td>
                <td>14555</td>
                <td>34</td>
                <td>Да</td>
            </tbody>
        </table>
    </div>
</div>
@endsection