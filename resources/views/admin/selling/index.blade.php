@extends('admin.layout') @section('content')
<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Продажби</h4>

            <form data-scan="{{ route('sellScan') }}">
                <div class="row gap-20 masonry pos-r">
                    <div class="masonry-sizer col-md-6"></div>
                    <div class="col-md-6 masonry-item form-horizontal">
                        <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                            <input type="checkbox" id="amount_check" name="amount_check" class="peer">
                            <label for="amount_check" class="peers peer-greed js-sb ai-c">
                                <span class="peer peer-greed">Повече от един продукт</span>
                            </label>
                        </div>
                        <div class="form-group form-row">
                            <label for="number_item" class="col-sm-9 control-label">Номер на артикула</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="number_item" id="number_item" placeholder="Артикулне номер">
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="catalog_number" class="col-sm-9 control-label">Каталожен номер</label>
                            <div class="col-sm-3">
                                <input type="email" class="form-control" id="catalog_number" name="catalog_number" placeholder="Номер от каталога">
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="amount" class="col-sm-9 control-label">Брой</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" value="1" id="amount" name="amount" placeholder="1">
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="discount" class="col-sm-9 control-label">Отстъпка</label>
                            <div class="col-sm-3">
                                <select id="discount" name="discount" class="form-control">
                                    <option value="">Избери</option>
    
                                    <option value="5">5%</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Описание</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
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
                            <button type="submit" class="btn btn-primary">Печат</button>
                        </div>

                        @foreach(Cart::content() as $row)
                            {{ $row->name }}
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection