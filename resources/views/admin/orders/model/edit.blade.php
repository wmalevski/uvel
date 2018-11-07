<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="fullEditRepairLabel">Промени поръчка</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <form method="POST" data-type="edit" name="custom_order" action="oders/model/{{ $order->id }}">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">    
                <div class="info-cont">
                </div>
            {{ csrf_field() }}
    
            <div class="form-group">
                <label for="1">Име на клиент: </label>
                <input type="text" class="form-control" value="{{ $order->user->name }}" id="1" name="name" placeholder="Име:" readonly>
            </div>

            <div class="form-group">
                <label for="2">Email на клиент: </label>
                <input type="email" class="form-control" value="{{ $order->user->email }}" id="2" name="email" placeholder="Email:" readonly>
            </div>

            <div class="form-group">
                <label for="3">Телефон на клиент: </label>
                <input type="tel" class="form-control" value="{{ $order->user->phone }}" id="3" name="phone" placeholder="Телефон:">
            </div>

            <div class="form-group">
                <label for="4">Град на клиент: </label>
                <input type="text" class="form-control" value="{{ $order->user->city }}" id="4" name="city" placeholder="Град:">
            </div>

            <div class="form-group">
                <label for="4">Описание на поръчката: </label>
                <textarea class="form-control" name="content">{{ $order->user->content }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group col-md-5">
                    <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                        @if($order->status == 'pending')
                            <input type="checkbox" id="inputCall1" name="status" class="peer" value="accepted">
                            <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                                <span class="peer peer-greed">Приемане</span>
                            </label>
                        @elseif($order->status == 'accepted')
                            <input type="checkbox" id="inputCall1" name="status" class="peer" value="ready">
                            <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                                <span class="peer peer-greed">Готов за предаване</span>
                            </label>
                        @elseif($order->status == 'ready')
                            <input type="checkbox" id="inputCall1" name="status" class="peer" value="delivered">
                            <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                                <span class="peer peer-greed">Получен</span>
                            </label>
                        @else 
                            Поръчката е успешно предадена и приета от клиента.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" data-state="edit_order" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
    </div>