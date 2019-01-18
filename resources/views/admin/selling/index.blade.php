@extends('admin.layout') @section('content')
<div class="modal fade" id="paymentPartner" role="dialog" aria-labelledby="paymentPartner" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentPartnerLabel">Плащане партньори</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="sell/partner" name="sellingPartners" data-type="partner-sell">
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}  

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <table class="table" id="partner-shopping-table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Материали</th>
                                        <th scope="col">В количката</th>
                                        <th scope="col">Даден</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>    
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="partner-information">Информация за партнъора:</label>
                            <p class="partner-information"></p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="partner-wanted-sum">Дължима сума</label>
                        </div>
                        <div class="form-group col-md-6">
                            <input class="form-control" id="partner-wanted-sum" type="number" name="partner-wanted-sum" readonly="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">    
                            <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                                <input type="checkbox" id="partner-pay-method" class="pay-method" name="partner-pay-method" data-calculatepayment-method="">
                                <label for="partner-pay-method" class="peers peer-greed js-sb ai-c">
                                    <span class="peer peer-greed">С карта</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="radio radio-info">
                                <input type="radio" id="partner-modal-reciept" name="partner-modal-reciept" value="yes" checked="">
                                <label for="partner-modal-reciept">Фискален</label>
                            </div>
                            <div class="radio radio-info">
                                <input type="radio" id="partner-modal-non-reciept" name="partner-modal-reciept" value="no">
                                <label for="partner-modal-non-reciept">Без фискален</label>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="radio radio-info">
                                <input type="radio" id="partner-modal-ticket" name="partner-modal-ticket" value="yes" checked="">
                                <label for="partner-modal-ticket">С разписка</label>
                            </div>
                            <div class="radio radio-info">
                                <input type="radio" id="partner-modal-non-ticket" name="partner-modal-ticket" value="no">
                                <label for="partner-modal-non-ticket">Без разписка</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <span>Принтиране на сертификат:</span>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="radio radio-info">
                                <input type="radio" id="partner-modal-certificate" name="partner-modal-certificate" value="yes" checked="">
                                <label for="partner-modal-certificate">С цена</label>
                            </div>
                            <div class="radio radio-info">
                                <input type="radio" id="partner-modal-non-certificate" name="partner-modal-certificate" value="no">
                                <label for="partner-modal-non-certificate">Без цена</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" class="btn btn-primary btn-finish-payment">Завърши плащането</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                        <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                            <input type="checkbox" id="exchange" class="exchange-method" name="exchange_method" class="peer" data-exchange-trigger>
                            <label for="exchange" class="peers peer-greed js-sb ai-c">
                                <span class="peer peer-greed">Обмяна</span>
                            </label>
                        </div>
                    </div>

                    <div id="exchange-row"> <!-- SHOW HIDE DEPENDING ON EXCHANGE CHECKBOX -->
                        <div class="exhange-row-controllers form-row">
                            <div class="form-group col-md-8">
                                <span data-expected-material='0'>Даден материал</span>
                            </div>
                            <div class="form-group col-md-4">
                                <button type="button" class="btn btn-primary" data-newExchangeField-trigger>Добави</button>
                            </div>
                        </div>

                        <div class="exchange-row-fields">
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="">Вид</label>
                                    <select id="material_type" name="material_id[]" data-select2-skip data-calculateprice-material class="material_type form-control calculate">
                                        <option value="0">Избери</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="">Грамаж</label>
                                    <input type="number" id="" class="form-control" value="0" name="weight[]" placeholder="" data-weight>
                                </div>
                                {{-- <div class="form-group col-md-4">
                                    <label for="">Цена на грамаж</label>
                                    <!-- AUTO GENERATED FROM JS -->
                                    <select id="retail_prices" name="retail_price_id[]" class="form-control calculate prices-filled retail-price" data-calculateprice-retail disabled>
                                        <option value="0">Избери</option>
                                    </select>
                                </div> --}}

                                <div class="form-group col-md-1">
                                    <span class="delete-material remove_field" data-exchangeRowRemove-trigger=""><i class="c-brown-500 ti-trash"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="exchange-row-total form-row">
                            <div class="form-group col-md-6">
                                <label for="given-sum">Сума от материали</label>
                                <input type="number" id="" data-defaultPrice="{{ $materials->first()->material->pricesBuy->first()->price }}" class="form-control" value="0" name="exchangeRows_total" placeholder="Дължима сума" data-exchangeRows-total readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="given-sum">Цена на грамаж</label>
                                <select name="calculating_price" class="form-control">
                                    <option value="0">Избери</option>
                                    @if($materials->first()->material->pricesBuy->first())
                                    @foreach($materials->first()->material->pricesBuy as $price)
                                        <option value="{{ $price->id }}" data-defaultPrice="{{ $materials->first()->material->pricesBuy->first()->price }}" data-price="{{ $price->price }}">{{ $price->slug }} - {{ $price->price }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
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
            <h4 class="c-grey-900 mB-20">Продажби <a href="{{ route('clear_cart') }}" class="btn btn-primary">Изчисти продажбата</a></h4>

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
                                <div class="input-group">
                                    <input type="text" class="form-control" name="discount"  id="discount" data-sell-discount placeholder="Проценти" >
                                    <span class="input-group-addon">%</span>
                                </div>
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
                            <textarea name="description" id="description" class="form-control" data-sell-description></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" id="add_discount" data-url="sendDiscount" class="btn btn-primary" data-sell-discountApply>Приложи</button>
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
                            <button type="button" class="btn btn-primary payment-btn" data-url="/ajax/cartMaterialsInfo" data-form-type="partner-sell" data-form="sellingPartners" data-toggle="modal" data-target="#paymentPartner" style="display: none;">Плащане Партнъор</button>
                            <button type="button" class="btn btn-primary">Ръчно пускане на фискален бон</button>
                        </div>


                        <div class="form-group form-row">
                            <label for="subTotal" class="col-sm-9 control-label">Цена (с ДДС):</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="price" name="subTotal" value="{{ Cart::session(Auth::user()->id)->getSubTotal() }}" class="form-control" id="subTotal" data-sell-subTotal placeholder="" readonly>
                                    <span class="input-group-addon">лв</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="tax" class="col-sm-9 control-label">ДДС:</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="price" name="tax" value="{{ $dds }}" class="form-control" id="tax" data-sell-tax placeholder="" readonly>
                                    <span class="input-group-addon">лв</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="subTotal" class="col-sm-9 control-label">Отстъпки:<br/>
                                <span class="discount--label-holder">
                                    @foreach($conditions as $condition)
                                        <span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">{{ $condition->getValue() }}</span>
                                        <span data-url="/ajax/removeDiscount/{{ $condition->getName() }}" data-sell-removeDiscount class="discount-remove badge bgc-red-50 c-red-700 p-10 lh-0 tt-c badge-pill"><i class="c-brown-500 ti-close"></i></span> <br/>

                                    @endforeach
                                </span>
                            </label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="price" name="subTotal" value="{{ $priceCon }}" class="form-control" id="subTotal" placeholder="" data-sell-discountDisplay readonly>
                                    <span class="input-group-addon">лв</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="total" class="col-sm-9 control-label">Крайна цена:</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="totalPrice" name="total" value="{{ round(Cart::session(Auth::user()->id)->getTotal(),2) }}" class="form-control" id="total" data-calculatePayment-total placeholder="" readonly>
                                    <span class="input-group-addon">лв</span>
                                </div>
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

@section('footer-scripts')
<script id="materials_data" type="application/json">
    {!!  $jsMaterials !!}
</script>
@endsection
