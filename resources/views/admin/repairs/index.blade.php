@extends('admin.layout') @section('content')
<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Ремонти</h4>
            <p>Приемане на артикул за ремонт</p>

            <form>
                <div class="row gap-20 masonry pos-r">
                    <div class="masonry-sizer col-md-6"></div>
                    <div class="col-md-6 masonry-item">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Име</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Име на клиент">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Телефон</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Телефон на клиента">
                            </div>
                        </div>
                        {{--
                        <div class="form-group">
                            <label for="inputAddress">Address</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Address 2</label>
                            <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                        </div> --}}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Номер на поръчката</label>
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputZip">Баркод</label>
                                <input type="text" class="form-control" id="inputZip">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Срок</label>
                                <div class="timepicker-input input-icon form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon bgc-white bd bdwR-0">
                                            <i class="ti-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control bdc-grey-200 start-date" placeholder="Срок" data-provide="datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputZip">Дата</label>
                                <div class="timepicker-input input-icon form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon bgc-white bd bdwR-0">
                                            <i class="ti-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control bdc-grey-200 start-date" placeholder="Дата" data-provide="datepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Описание</label>
                            <textarea class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Тип ремонт</label>
                            <select id="repair_type" name="repair_type" class="form-control">
                                <option value="">Избери</option>

                                @foreach($repairTypes as $repairType)
                                <option value="{{ $repairType->id }}">{{ $repairType->name }} - {{ $repairType->price }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Сертификат</button>
                    </div>
                    <div class="col-md-6 masonry-item form-horizontal">
                        <div class="form-group">
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


                        {{--  <div class="form-group">
                            <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                                <input type="checkbox" id="inputCall2" name="inputCheckboxesCall" class="peer">
                                <label for="inputCall2" class="peers peer-greed js-sb ai-c">
                                    <span class="peer peer-greed">Обмяна</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Даден материал в карати</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Име на клиент">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Даден материал в 14к</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Телефон на клиента">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Готов продукт в 14к</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Телефон на клиента">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Разлика в гр.</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Име на клиент">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Разлика в лв.</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Телефон на клиента">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Цена</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Име на клиент">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Капаро</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Телефон на клиента">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Остатък</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Телефон на клиента">
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
                        </div>  --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection