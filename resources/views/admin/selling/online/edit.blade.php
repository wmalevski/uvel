<div class="editPaymentWrapper">
        <div class="modal-header">
            <h5 class="modal-title" id="editPaymentLabel">Информация за онлайн продажба</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="POST" action="selling/online/{{ $selling->id }}" name="editPayments" data-type="edit">
            <input name="_method" type="hidden" value="PUT">
            <div class="modal-body">    
                <div class="info-cont">
                </div>
        
                {{ csrf_field() }}  
                            
                <div class="form-row">
                    <div class="form-group col-md-6">
                        Име на клиент: {{ $selling->user->first_name }} - {{ $selling->user->last_name }}
                    </div>
                    <div class="form-group col-md-6">
                        Телефон: {{ $selling->user->phone }}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        Начин на плащане: @if($selling->payment_method == 'on_delivery')
                        Наложен платеж
                    @elseif($selling->payment_method == 'paypal') 
                        Paypal
                    @endif
                    </div>
                    <div class="form-group col-md-6">
                        Начин на получаване: @if($selling->shipping_method == 'ekont')
                        Еконт
                    @elseif($selling->shipping_method == 'store') 
                        Взимане от магазин ({{ $selling->store->name }})
                    @endif
                    </div>
                </div>

                <div class="form-row">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Баркод</th>
                                    <th scope="col">Брой</th>
                                    <th scope="col">Тегло</th>
                                    <th scope="col">Цена</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <th scope="row">
                                            @if($product->product_id)
                                                {{ $product->product_id }}
                                            @elseif($product->product_other_id)
                                                {{ $product->product_other_id }}
                                            @elseif($product->model_id)
                                                {{ $product->model_id }}
                                            @endif
                                        </th>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->weight }}</td>
                                        <td>{{ $product->price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
        
                    {{-- <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Приемане</label>
                            <div class="timepicker-input input-icon form-group date-recieved">
                                <div class="input-group">
                                    <div class="input-group-addon bgc-white bd bdwR-0">
                                        <i class="ti-calendar"></i>
                                    </div>
                                <input readonly type="text" value="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" class="form-control bdc-grey-200 start-date" name="date_recieved" placeholder="Дата на приемане" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-clear="false">
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
                                    <input type="text" data-date-format="dd-mm-yyyy" name="date_returned" class="form-control bdc-grey-200 start-date" placeholder="Дата на връщане" data-date-autoclose="true" data-provide="datepicker" value="{{ $repair->date_returned }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <textarea class="form-control" name="repair_description">{{ $repair->repair_description }}</textarea>
                    </div>
        
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Тип ремонт</label>
                            <select name="type_id" class="form-control fill-field" data-fieldToFill="input[name='price']" data-repair-type>
                                <option value="">Избери</option>
        
                                @foreach($repairTypes as $repairType)
                                    <option value="{{ $repairType->id }}" data-price="{{ $repairType->price }}" @if($repair->type->id == $repairType->id) selected @endif>{{ $repairType->name }} - {{ $repairType->price }}</option>
                                @endforeach
                            </select>
                        </div>
        
                        <div class="form-group col-md-6">
                            <label>Материал: </label>
                            <select name="material_id" class="form-control" data-repair-material>
                                <option value="">Избер материал</option>
                        
                                @foreach($materials as $material)
                                    @if($material->pricesSell->first())
                                        <option data-price="{{ $material->pricesBuy->first()->price }}" value="{{ $material->id }}" @if($repair->material_id == $material->id) selected @endif>@if($material->parent) {{ $material->parent->name }} @endif - {{ $material->color }} - {{ $material->code }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
        
        
                    {{-- <div class="form-row">
                        <div class="form-group col-md-23">
                            <label for="inputEmail4">Цена</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="price" value="{{ $selling->price }}" placeholder="Цена на ремонта" data-repair-price readonly>
                                <span class="input-group-addon">лв</span>
                            </div>
                        </div>
                        {{-- <div class="form-group col-md-6">
                            <label for="inputEmail4">Цена след ремонта</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="price_after" data-repair-priceAfter @if($repair->price_after == '') value="{{ $repair->price }}" @else value="{{ $repair->price_after }}" @endif placeholder="Цена на ремонта">
                                <span class="input-group-addon">лв</span>
                            </div>
                        </div> --}}
                    {{-- </div> --}} 
        
                    {{-- <div class="form-row">
                        <div class="form-group col-md-5">
                            <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                                <input type="checkbox" id="inputCall1" name="status" class="peer" value="done">
                                <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                                    <span class="peer peer-greed">Готов за връщане</span>
                                </label>
                            </div>
                        </div>
                    </div> --}}
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                <button type="submit" id="edit" class="edit-btn-modal btn btn-primary">Предай и приключи</button>
            </div>
        </form>
        </div>