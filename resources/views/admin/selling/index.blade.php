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
            <form method="POST" action="repairs" name="fullEditRepair">
                 
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


<div class="modal fade payment-modal" id="paymentModal" role="dialog" aria-labelledby="paymentModal"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Плащане</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="sell/payment" name="selling" data-type="sell">
                 
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>

                    {{ csrf_field() }}  

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="wanted-sum">Дължима сума</label>
                        </div>
                        <div class="form-group col-md-6">
                            <input class="form-control" id="wanted-sum" type="number" name="wanted_sum" data-calculatePayment-wanted readonly>
                        </div>
                    </div>
                                
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="given-sum">Дадена сума</label>
                            <input type="number" id="given-sum" class="form-control" value="0" name="given_sum" data-calculatePayment-given placeholder="Дадена сума от клиента">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="return-sum">Ресто</label>
                            <input type="number" id="return-sum" class="form-control" name="return_sum" data-calculatePayment-return placeholder="Ресто" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="pay-currency">Валута</label>
                            <select id="pay-currency" name="pay_currency" class="form-control" data-calculatePayment-currency>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}" data-default="{{$currency->default }}" data-currency="{{ $currency->currency }}" @if($currency->default == "yes") selected @endif >{{ $currency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <!-- <div class="radio radio-info">
                                <input type="radio" name="pay_method" value="cash" id="pay-method-cash" checked>
                                <label for="pay-method-cash">В брой</label>
                            </div>
                            <div class="radio radio-info">
                                <input type="radio" name="pay_method" value="pos" id="pay-method-pos">
                                <label for="pay-method-pos">С карта</label>
                            </div> -->
                            <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                                <input type="checkbox" id="pay-method" class="pay-method" name="pay_method" class="peer" data-calculatePayment-method>
                                <label for="pay-method" class="peers peer-greed js-sb ai-c">
                                    <span class="peer peer-greed">С карта</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="radio radio-info">
                                <input type="radio" id="modal-reciept" name="modal_reciept" value="yes" checked>
                                <label for="modal-reciept">Фискален</label>
                            </div>
                            <div class="radio radio-info">
                                <input type="radio" id="modal-non-reciept" name="modal_reciept" value="no">
                                <label for="modal-non-reciept">Без фискален</label>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="radio radio-info">
                                <input type="radio" id="modal-ticket" name="modal_ticket" value="yes" checked>
                                <label for="modal-ticket">С разписка</label>
                            </div>
                            <div class="radio radio-info">
                                <input type="radio" id="modal-non-ticket" name="modal_ticket" value="no">
                                <label for="modal-non-ticket">Без разписка</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <span>Принтиране на сертификат:</span>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="radio radio-info">
                                <input type="radio" id="modal-certificate" name="modal_certificate" value="yes" checked>
                                <label for="modal-certificate">С цена</label>
                            </div>
                            <div class="radio radio-info">
                                <input type="radio" id="modal-non-certificate" name="modal_certificate" value="no">
                                <label for="modal-non-certificate">Без цена</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="button" class="btn btn-primary">Печат</button>
                    <button type="submit" class="btn btn-primary btn-finish-payment">Завърши плащането</button>
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
                            <input type="checkbox" id="amount_check" name="amount_check" data-sell-moreProducts class="peer">
                            <label for="amount_check" class="peers peer-greed js-sb ai-c">
                                <span class="peer peer-greed">Повече от един продукт</span>
                            </label>
                        </div>
                        <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                            <input type="checkbox" id="type_repair" name="type_repair" data-sell-repair class="peer">
                            <label for="type_repair" class="peers peer-greed js-sb ai-c">
                                <span class="peer peer-greed">Ремонт</span>
                            </label>
                        </div>
                        <div class="form-group form-row">
                            <label for="product_barcode" class="col-sm-9 control-label">Номер на артикула</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="product_barcode" id="product_barcode" data-sell-barcode placeholder="Баркод:">
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="catalog_number" class="col-sm-9 control-label">Каталожен номер</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="catalog_number" name="catalog_number" data-sell-catalogNumber placeholder="Номер от каталога:">
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="amount" class="col-sm-9 control-label">Брой</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" value="1" id="amount" name="amount" data-sell-productsAmount placeholder="1" readonly>
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="discount" class="col-sm-9 control-label">Отстъпка</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="discount" data-url="senddiscount" id="discount" data-sell-discount placeholder="Проценти" >
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="discount_card" class="col-sm-9 control-label">Сканирай карта за отстъпка</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" name="discount_card" data-url="setDiscount/" id="discount_card" data-sell-discountCard placeholder="Баркод" min="1">
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
                            <button type="button" class="btn btn-primary payment-btn" data-selling-payment data-form-type="sell" data-form="selling" data-toggle="modal" data-target="#paymentModal">Плащане</button>
                            <button type="button" class="btn btn-primary">Ръчно пускане на фискален бон</button>
                        </div>


                        <div class="form-group form-row">
                            <label for="subTotal" class="col-sm-9 control-label">Цена</label>
                            <div class="col-sm-3">
                                <input type="price" name="subTotal" value="{{ Cart::session(Auth::user()->id)->getSubTotal() }}" class="form-control" id="subTotal"
                                data-sell-subTotal placeholder="" readonly>
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="subTotal" class="col-sm-9 control-label">Отстъпки(
                                @foreach($conditions as $condition)
                                    @if($condition->getName() != 'ДДС'){{ $condition->getValue() }}@endif
                                @endforeach
                            )</label>
                            <div class="col-sm-3">
                                <input type="price" name="subTotal" value="{{ $priceCon }}" class="form-control" id="subTotal" placeholder="" readonly>
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="total" class="col-sm-9 control-label">Крайна цена(с ДДС +20%)</label>
                            <div class="col-sm-3">
                                <input type="totalPrice" name="total" value="{{ Cart::session(Auth::user()->id)->getTotal() }}" class="form-control" id="total" data-calculatePayment-total placeholder="" readonly>
                            </div>
                        </div>

                        {{-- <div class="form-group form-row">
                            <label for="inputEmail3" class="col-sm-9 control-label">Количество</label>
                            <div class="col-sm-3">
                                <input type="totalQuantity" value="{{ Cart::session(Auth::user()->id)->getTotalQuantity() }}" class="form-control" id="inputEmail3" placeholder="" readonly>
                            </div>
                        </div> --}}

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