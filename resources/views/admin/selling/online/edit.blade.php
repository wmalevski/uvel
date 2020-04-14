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
                        Начин на получаване: @if($selling->shipping_method == 'office_address')
                        Вземане от офис на куриер
                    @elseif($selling->shipping_method == 'store') 
                        Вземане от магазин ({{ $selling->store->name }})
                    @elseif($selling->shipping_method == 'home_address')
                        Доставка до адрес
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
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                @if($selling->status != 'done')
                    <button type="submit" id="edit" class="edit-btn-modal btn btn-primary">Предай и приключи</button>
                @endif
            </div>
        </form>
        </div>