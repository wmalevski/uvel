<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="editPriceLabel">Промяна на цена</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <form method="POST" name="edit" action="prices/{{ $price->id }}">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">    
            <div class="info-cont">
            </div>
    
            {{ csrf_field() }}
    
            <div class="form-group">
                <label for="1">Име: </label>
                <input type="text" class="form-control" id="1" name="slug" value="{{ $price->slug }}" placeholder="Етикет:">
            </div>
        
            <div class="form-group">
                <label for="2">Стойност: </label>
                <input type="number" class="form-control" id="2" value="{{ $price->price }}" name="price" placeholder="Цена:">
            </div>
        
            <label>Тип: </label>
            <select name="type" class="form-control">
                <option value="">Избери тип</option>
        
                <option value="buy" @if($price->type == "buy") selected @endif>Купува</option>
                <option value="sell" @if($price->type == "sell") selected @endif>Продава</option>
            </select>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="add" class="edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
</div>