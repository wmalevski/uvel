@extends('admin.layout') @section('content')


<div class="modal fade" id="addRepair" role="dialog" aria-labelledby="addRepair"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRepairLabel">Добавяне на артикул за ремонт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="repairs" name="repairs" data-type="add" autocomplete="off">
                 
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>

                    {{ csrf_field() }}  
                                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Име</label>
                            <input type="text" class="form-control" name="customer_name" placeholder="Име на клиент">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Телефон</label>
                            <input type="number" class="form-control" name="customer_phone" placeholder="Телефон на клиента">
                        </div>
                    </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Приемане</label>
                                <div class="input-icon form-group date-recieved">
                                    <div class="input-group">
                                        <div class="input-group-addon bgc-white bd bdwR-0">
                                            <i class="ti-calendar"></i>
                                        </div>
                                    <input readonly type="text" value="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" class="form-control bdc-grey-200 not-clear" name="date_recieved" placeholder="Дата на приемане">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputZip">Срок</label>
                                <div class="timepicker-input input-icon form-group date-returned">
                                    <div class="input-group">
                                        <div class="input-group-addon bgc-white bd bdwR-0">
                                            <i class="ti-calendar"></i>
                                        </div>
                                        <input type="text" data-date-autoclose="true" data-date-format="dd-mm-yyyy" name="date_returned" class="form-control bdc-grey-200 start-date" placeholder="Дата на връщане" data-date-start-date="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" data-provide="datepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Описание</label>
                            <textarea class="form-control" name="repair_description"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Тип ремонт</label>
                                <select name="type_id" class="form-control fill-field" data-fieldToFill="input[name='price']" data-repair-type data-search="/ajax/select_search/repairtypes/">
                                    <option value="">Избери</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Материал: </label>
                                <select name="material_id" class="form-control" data-search="/ajax/select_search/global/materials/">
                                    <option value="">Избер материал</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Тегло</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="weight" placeholder="Тегло на артикула">
                                    <span class="input-group-addon">гр.</span>
                                </div>
                            </div>

 
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Цена</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="price" placeholder="Цена на ремонта" data-repair-price>
                                    <span class="input-group-addon">лв</span>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="button" id="certificate" disabled class="certificate btn btn-primary">Разписка</button>
                    <button type="submit" id="add" class="btn btn-primary add-btn-modal">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="fullEditRepair" role="dialog" aria-labelledby="fullEditRepair"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullEditRepairLabel">Редактиране на артикул за ремонт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="repairs" name="fullEditRepair">
                 
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>

                    {{ csrf_field() }}  
                                

                    
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="returnRepair" role="dialog" aria-labelledby="returnRepair"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id='return-repair-wrapper'>
            <div class="modal-header">
                <h5 class="modal-title" id="returnRepairLabel">Връщане на ремонтиран артикул</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" data-type="add" action="repairs/return" id='return-repair-form' name="returnRepair">
                 
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>

                    {{ csrf_field() }}  
                                

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="barcode_return-repairs">Баркод</label>
                            <input type="text" class="form-control" id="barcode_return-repairs" name="barcode" data-repair-scan="return" placeholder="Моля сканирайте баркода за артикула">
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="scanRepair" role="dialog" aria-labelledby="scanRepair"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div id='scan-repair-wrapper'>
                <div class="modal-header">
                    <h5 class="modal-title" id="scanRepairLabel">Обработка на ремонтиран артикул</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" data-type="add" action="repairs/return" id='scan-repair-form' name="scanRepair">
                    
                    <div class="modal-body">    
                        <div class="info-cont">
                        </div>

                        {{ csrf_field() }}  
                                    

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="barcode_process-repairs">Баркод</label>
                                <input type="text" class="form-control" id="barcode_process-repairs" data-repair-scan="edit" data-form-type="edit" data-form="repairs" name="barcode" placeholder="Моля сканирайте баркода за артикула">
                            </div>
                        </div>

                        {{--  <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Име</label>
                                <input type="text" class="form-control" name="customer_name" placeholder="Име на клиент">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Телефон</label>
                                <input type="text" class="form-control" name="customer_phone" placeholder="Телефон на клиента">
                            </div>
                        </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCity">Приемане</label>
                                    <div class="timepicker-input input-icon form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon bgc-white bd bdwR-0">
                                                <i class="ti-calendar"></i>
                                            </div>
                                        <input type="text" value="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" class="form-control bdc-grey-200 start-date" name="date_recieved" placeholder="Дата на приемане" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputZip">Срок</label>
                                    <div class="timepicker-input input-icon form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon bgc-white bd bdwR-0">
                                                <i class="ti-calendar"></i>
                                            </div>
                                            <input type="text" data-date-format="dd-mm-yyyy" name="date_returned" class="form-control bdc-grey-200 start-date" placeholder="Дата на връщане" data-date-autoclose="true" data-provide="datepicker">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Описание</label>
                                <textarea class="form-control" name="repair_description"></textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Тип ремонт</label>
                                    <select name="type" class="form-control">
                                        <option value="">Избери</option>
        
                                        @foreach($repairTypes as $repairType)
                                            <option value="{{ $repairType->id }}" data-price="{{ $repairType->price }}">{{ $repairType->name }} - {{ $repairType->price }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Тегло</label>
                                    <input type="text" class="form-control" name="weight" placeholder="Тегло на артикула">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Карати</label>
                                    <input type="text" class="form-control" name="carates" placeholder="Карати">
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Цена</label>
                                    <input type="text" class="form-control" name="prize" placeholder="Цена на ремонта">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Капаро</label>
                                    <input type="text" class="form-control" name="deposit" placeholder="Оставено капаро">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                                    <input type="checkbox" id="inputCall2" name="inputCheckboxesCall" class="peer">
                                    <label for="inputCall2" class="peers peer-greed js-sb ai-c">
                                        <span class="peer peer-greed">Фискален</span>
                                    </label>
                                </div>

                                <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                                    <input type="checkbox" id="inputCall2" name="inputCheckboxesCall" class="peer">
                                    <label for="inputCall2" class="peers peer-greed js-sb ai-c">
                                        <span class="peer peer-greed">Без</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Плащане</button>
                                <button type="submit" class="btn btn-primary">Ръчно пускане на фискален бон</button>
                            </div>  --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Ремонти 
                <button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="repairs" data-toggle="modal" data-target="#addRepair">Добави</button> 
                <button type="button" class="return-repair btn btn-primary" data-form-type="add" data-form="returnRepair" data-toggle="modal" data-target="#returnRepair">Върни</button> 
                <button type="button" class="scan-repair btn btn-primary" data-form-type="add" data-form="scanRepair" data-toggle="modal" data-target="#scanRepair">Обработи</button></h4>
            <p>Артикули за ремонт</p>
            <table id="main_table" class="table repair-records-table tablesort table-fixed">
                <thead>
                    <tr data-sort-method="thead">
                        <th scope="col">Баркод</th>
                        <th scope="col">Уникален номер</th>
                        <th scope="col">Име</th>
                        <th data-sort-method="none" scope="col">Телефон</th>
                        <th scope="col">Тип ремонт</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Статус</th>
                        <th data-sort-method="none" scope="col">Действия</th>
                    </tr>
                    <tr class="search-inputs" data-dynamic-search-url="ajax/search/repairs/">
                        <th>
                            <input class="filter-input form-control" type="text" data-dynamic-search-param="byBarcode=" placeholder="Търси по баркод">
                        </th>
                        <th>
                            <input class="filter-input form-control" type="text" data-dynamic-search-param="byCode=" placeholder="Търси по номер">
                        </th>
                        <th>
                            <input class="filter-input form-control" type="text" data-dynamic-search-param="byName=" placeholder="Търси по име">
                        </th>
                        <th>
                            <input class="filter-input form-control" type="text" data-dynamic-search-param="byPhone=" placeholder="Търси по телефон">
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($repairs as $repair)
                        @include('admin.repairs.table')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
