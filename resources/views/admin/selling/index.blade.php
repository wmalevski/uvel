@extends('admin.layout') @section('content')
<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Продажби</h4>

            <form>
                <div class="row gap-20 masonry pos-r">
                    <div class="masonry-sizer col-md-6"></div>
                    <div class="col-md-6 masonry-item form-horizontal">
                        <div class="form-group form-row">
                            <label for="inputEmail3" class="col-sm-9 control-label">Номер на артикула</label>
                            <div class="col-sm-3">
                                <input type="email" class="form-control" id="inputEmail3" placeholder="Артикулне номер">
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="inputEmail3" class="col-sm-9 control-label">Каталожен номер</label>
                            <div class="col-sm-3">
                                <input type="email" class="form-control" id="inputEmail3" placeholder="Номер от каталога">
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="inputEmail3" class="col-sm-9 control-label">Брой</label>
                            <div class="col-sm-3">
                                <input type="email" class="form-control" id="inputEmail3" placeholder="1">
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="inputEmail3" class="col-sm-9 control-label">Отстъпка</label>
                            <div class="col-sm-3">
                                <select id="repair_type" name="repair_type" class="form-control">
                                    <option value="">Избери</option>
    
                                    <option value="5">5%</option>
                                </select>
                            </div>
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
                            <button type="submit" class="btn btn-primary">Обмяна</button>
                            <button type="submit" class="btn btn-primary">Поръчка/Ремонт</button>
                            <button type="submit" class="btn btn-primary">Материали</button>
                            <button type="submit" class="btn btn-primary">Транзакции </button>
                        </div>
                    </div>
                    <div class="col-md-6 masonry-item form-horizontal">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Модел</th>
                                    <th scope="col">Уникален номер</th>
                                    <th scope="col">Грамаж</th>
                                    <th scope="col">Цена</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>

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

                        <div class="form-group form-row">
                            <label for="inputEmail3" class="col-sm-9 control-label">Цена</label>
                            <div class="col-sm-3">
                                <input type="email" class="form-control" id="inputEmail3" placeholder="">
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="inputEmail3" class="col-sm-9 control-label">Количество</label>
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
                            <button type="submit" class="btn btn-primary">Печат</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection