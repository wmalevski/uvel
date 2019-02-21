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
        <h3>Продажби по обект, ниво 2</h3>
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
    <div class="col-md-12">
        <p style="font-weight: bold; margin: 20px 0 0 0;">Магазин 1</p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed tablesort">
            <thead>
                <tr data-sort-method="thead">
                    <th>Продажба</th>
                    <th>Уникален номер</th>
                    <th>Модел</th>
                    <th>Вид бижу</th>
                    <th>Материал</th>
                    <th>Брой</th>
                    <th>Стойност</th>
                    <th>Отстъпка</th>
                    <th>След отстъпка лв.</th>
                    <th>С карта/кеш</th>
                    <th>Дата</th>
                    <th>Служител</th>
                </tr>
                <tr class="reports-search-inputs">
                    <th>
                        <input class="search-input form-control" type="number" placeholder="Търси по продажба" data-column-sort="0" autocomplete="off">
                    </th>
                    <th>
                        <input class="search-input form-control" type="text" placeholder="Търси по номер" data-column-sort="1" autocomplete="off">
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <span data-url="/enterurl" class="edit-btn" data-detailed-view data-toggle="modal" data-target="#viewModal" data-form-type="export-detailed" data-form="exportDetailedView">
                            <i class="c-brown-500 ti-eye"></i>
                        </span>
                      
                        523
                    </td>
                    <td>112352</td>
                    <td>dp264</td>
                    <td>мъжки пръстен</td>
                    <td>Сребро - Бяло - 925</td>
                    <td>2</td>
                    <td>2000</td>
                    <td>2000</td>
                    <td>1800</td>
                    <td>карта</td>
                    <td>11.02.2019</td>
                    <td>Жоро</td>
                </tr>
                <tr>
                    <td>
                        <span data-url="/enterurl2" class="edit-btn" data-detailed-view data-toggle="modal" data-target="#viewModal" data-form-type="export-detailed" data-form="exportDetailedView">
                            <i class="c-brown-500 ti-eye"></i>
                        </span>
                        001
                    </td>
                    <td>112352</td>
                    <td>dp264</td>
                    <td>мъжки пръстен</td>
                    <td>Сребро - Бяло - 925</td>
                    <td>2</td>
                    <td>2000</td>
                    <td>2000</td>
                    <td>1800</td>
                    <td>карта</td>
                    <td>11.02.2019</td>
                    <td>Жоро</td>
                </tr>
                <tr>
                    <td>
                        <span data-url="/enterurl3" class="edit-btn" data-detailed-view data-toggle="modal" data-target="#viewModal" data-form-type="export-detailed" data-form="exportDetailedView">
                            <i class="c-brown-500 ti-eye"></i>
                        </span>
                        002
                    </td>
                    <td>40500</td>
                    <td>dp264</td>
                    <td>мъжки пръстен</td>
                    <td>Сребро - Бяло - 925</td>
                    <td>2</td>
                    <td>2000</td>
                    <td>2000</td>
                    <td>1800</td>
                    <td>карта</td>
                    <td>11.02.2019</td>
                    <td>Атанас</td>
                </tr>
            </tbody>
        </table>
        <div class="table-results" style="display: none;">Няма намерени резултати</div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="viewModal" role="dialog" aria-labelledby="viewModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductLabel">Информация за Продажба</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/pickurl" name="exportDetailedView" data-type="export-detailed"> 
                <div class="modal-body">    
                {{ csrf_field() }}  
                    <div class="form-row">
                        <div class="col-md-12">
                            <table class="table table-condensed tablesort">
                                <thead class="thead-dark">
                                    <tr data-sort-method="thead">
                                        <th>Материал (вид)</th>
                                        <th>Грамове</th>
                                        <th>Стойност</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>злато - жълто - 585</td>
                                        <td>15</td>
                                        <td>30</td>
                                    </tr>
                                    <tr>
                                        <td>злато - жълто - 565</td>
                                        <td>15</td>
                                        <td>30</td>
                                    </tr>
                                    <tr>
                                        <td>злато - жълто - 505</td>
                                        <td>15</td>
                                        <td>30</td>
                                    </tr>
                                </tbody>
                            </table>
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
@endsection