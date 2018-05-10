@extends('admin.layout') @section('content')

<div class="modal fade" id="fullEditRepair" role="dialog" aria-labelledby="fullEditRepair"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullEditRepairLabel">Редактиране на артикул за ремонт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/repairs" name="fullEditRepair">
                 
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


<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Продажби <a href="{{ route('clearCart') }}" class="btn btn-primary">Изчисти продажбата</a></h4>

            <form id="selling-form" data-scan="{{ route('sellScan') }}">
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
                            <label for="product_barcode" class="col-sm-9 control-label">Номер на артикула</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="product_barcode" id="product_barcode" placeholder="Артикулен номер">
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="catalog_number" class="col-sm-9 control-label">Каталожен номер</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="catalog_number" name="catalog_number" placeholder="Номер от каталога">
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="amount" class="col-sm-9 control-label">Брой</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" value="1" id="amount" name="amount" placeholder="1" readonly>
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="discount" class="col-sm-9 control-label">Отстъпка</label>
                            <div class="col-sm-3">
                                <select id="discount" name="discount" class="form-control">
                                    <option value="">Избери</option>
                                    
                                    @foreach($discounts as $discount)
                                        <option value="{{ $discount->barcode }}">{{ $discount->discount }}%</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="discount_card" class="col-sm-9 control-label">Сканирай карта за отстъпка</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="discount_card" id="discount_card" placeholder="Баркод" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Описание</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Предложи отстъпка</button>
                            <button type="submit" id="add_discount" data-url="sell/setDiscount" class="btn btn-primary">Приложи</button>
                        </div>

                        {{-- <div class="form-group">
                            <button type="submit" class="btn btn-primary">Обмяна</button>
                            <button type="submit" class="btn btn-primary">Поръчка/Ремонт</button>
                            <button type="submit" class="btn btn-primary">Материали</button>
                            <button type="submit" class="btn btn-primary">Транзакции </button>
                        </div> --}}
                    </div>
                    <div class="col-md-6 masonry-item form-horizontal">
                        <table class="table" id="shopping-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Артикул</th>
                                    <th scope="col">Брой</th>
                                    <th scope="col">Грам</th>
                                    <th scope="col">Цена</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    @include('admin.selling.table')
                                @endforeach
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

                        @foreach($conditions as $condition)
                            <div>{{ $condition->getName() }} {{ $condition->getValue() }}</div>
                        @endforeach
                        <br/>

                        <div class="form-group form-row">
                            <label for="subTotal" class="col-sm-9 control-label">Цена</label>
                            <div class="col-sm-3">
                                <input type="price" name="subTotal" value="{{ Cart::session(Auth::user()->id)->getSubTotal() }}" class="form-control" id="subTotal" placeholder="" readonly>
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="total" class="col-sm-9 control-label">Крайна цена</label>
                            <div class="col-sm-3">
                                <input type="totalPrice" name="total" value="{{ Cart::session(Auth::user()->id)->getTotal() }}" class="form-control" id="total" placeholder="" readonly>
                            </div>
                        </div>

                        {{-- <div class="form-group form-row">
                            <label for="inputEmail3" class="col-sm-9 control-label">Количество</label>
                            <div class="col-sm-3">
                                <input type="totalQuantity" value="{{ Cart::session(Auth::user()->id)->getTotalQuantity() }}" class="form-control" id="inputEmail3" placeholder="" readonly>
                            </div>
                        </div> --}}

                        <div class="form-group">
                            <a href="sellings/information" class="btn btn-primary print-btn">Печат</a>
                        </div>

                        {{-- @foreach(Cart::content() as $row)
                            {{ $row->name }}
                        @endforeach --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection