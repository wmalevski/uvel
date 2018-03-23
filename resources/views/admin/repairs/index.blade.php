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
            <form method="POST" action="/repairs" name="addRepair">
                 
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
                                    <input readonly type="text" value="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" class="form-control bdc-grey-200 start-date" name="date_recieved" placeholder="Дата на приемане" data-date-format="dd-mm-yyyy" data-provide="datepicker" data-clear="false">
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
                                        <input type="text" data-date-format="dd-mm-yyyy" name="date_returned" class="form-control bdc-grey-200 start-date" placeholder="Дата на връщане" data-provide="datepicker">
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
                                <select name="type" class="form-control fill-field" data-fieldToFill="input[name='price']">
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
                                <input type="text" class="form-control" name="price" placeholder="Цена на ремонта">
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
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="button" id="certificate" disabled class="btn btn-primary">Сертификат</button>
                    <button type="submit" id="add" class="btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editRepair" role="dialog" aria-labelledby="editRepair"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRepairLabel">Редактиране на артикул за ремонт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/repairs" name="editRepair">
                 
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>

                    {{ csrf_field() }}  
                                

                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" class="btn btn-primary">Завърши ремонта</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="returnRepair" role="dialog" aria-labelledby="returnRepair"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returnRepairLabel">Връщане на ремонтиран артикул</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/repairs/return" name="returnRepair">
                 
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>

                    {{ csrf_field() }}  
                                

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Баркод</label>
                            <input type="text" class="form-control" name="barcode" placeholder="Моля сканирайте баркода за артикула">
                        </div>
                    </div>

                    <div class="form-row">
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
                                    <input type="text" value="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" class="form-control bdc-grey-200 start-date" name="date_recieved" placeholder="Дата на приемане" data-date-format="dd-mm-yyyy" data-provide="datepicker">
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
                                        <input type="text" data-date-format="dd-mm-yyyy" name="date_returned" class="form-control bdc-grey-200 start-date" placeholder="Дата на връщане" data-provide="datepicker">
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
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" class="btn btn-primary">Върни</button>
                </div>
            </form>
        </div>
    </div>
</div>





<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Ремонти <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addRepair">Добави</button> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#returnRepair">Върни</button></h4>
            <p>Артикули за ремонт</p>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Баркод</th>
                        <th scope="col">Уникален номер</th>
                        <th scope="col">Име</th>
                        <th scope="col">Телефон</th>
                        <th scope="col">Тип ремонт</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($repairs as $repair)
                        @include('admin.repairs.table')
                    @endforeach
                </tbody>
            </table>
            {{--  <div class="form-group">
                <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                    <input type="checkbox" id="inputCall2" name="inputCheckboxesCall" class="peer">
                    <label for="inputCall2" class="peers peer-greed js-sb ai-c">
                        <span class="peer peer-greed">Обмяна</span>
                    </label>
                </div>
            </div>

            <div class="form-group form-row">
                <label for="inputEmail3" class="col-sm-9 control-label">Даден материал в карати</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control" id="inputEmail3" placeholder="">
                </div>
            </div>

            <div class="form-group form-row">
                <label for="inputEmail3" class="col-sm-9 control-label">Даден материал в 14к</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control" id="inputEmail3" placeholder="">
                </div>
            </div>

            <div class="form-group form-row">
                <label for="inputEmail3" class="col-sm-9 control-label">Готов продукт в 14к</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control" id="inputEmail3" placeholder="">
                </div>
            </div>

            <div class="form-group form-row">
                <label for="inputEmail3" class="col-sm-9 control-label">Разлика в гр.</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control" id="inputEmail3" placeholder="">
                </div>
            </div>

            <div class="form-group form-row">
                <label for="inputEmail3" class="col-sm-9 control-label">Разлика в лв.</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control" id="inputEmail3" placeholder="">
                </div>
            </div>

            <div class="form-group form-row">
                <label for="inputEmail3" class="col-sm-9 control-label">Цена</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control" id="inputEmail3" placeholder="">
                </div>
            </div>

            <div class="form-group form-row">
                <label for="inputEmail3" class="col-sm-9 control-label">Капаро</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control" id="inputEmail3" placeholder="">
                </div>
            </div>

            <div class="form-group form-row">
                <label for="inputEmail3" class="col-sm-9 control-label">Остатък</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control" id="inputEmail3" placeholder="">
                </div>
            </div>

            <div class="form-group">
                <label>Отстъпка</label>
                <select id="repair_type" name="repair_type" class="form-control">
                    <option value="">Избери</option>
                </select>
            </div>

            <div class="form-group">
                <label>Описание</label>
                <textarea class="form-control"></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Приложи отстъпка</button>
                <button type="submit" class="btn btn-primary">Приложи</button>
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
                        <span class="peer peer-greed">Служебен</span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Плащане</button>
                <button type="submit" class="btn btn-primary">Ръчно пускане на фискален бон</button>
            </div>  --}}
        
        </div>
    </div>
</div>
@endsection