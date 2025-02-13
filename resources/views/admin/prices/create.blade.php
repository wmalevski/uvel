<div class="modal-header">
    <h5 class="modal-title" id="addPriceLabel">Добавяне на цена</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form method="POST" name="prices" data-type="add" action="prices/{{$material->id}}">
    <div class="modal-body">
        <div class="info-cont">
        </div>
        {{ csrf_field() }}
            <div class="form-group">
                <label for="1">Име: </label>
                <input type="text" class="form-control" id="1" name="slug" placeholder="Етикет:">
            </div>
        
            <div class="form-group">
                <label for="2">Стойност: </label>
                <div class="input-group">
                    <input type="number" class="form-control" id="2" name="price" placeholder="Цена:">
                    <span class="input-group-addon">лв / гр.</span>
                </div>
            </div>
        
            <label>Тип: </label>
            <select name="type" class="form-control">
                <option value="">Избери тип</option>
        
                <option value="buy">Купува</option>
                <option value="sell">Продава</option>
            </select>
            <input type="hidden" name="material_id" value="{{ $material->id }}">
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="add" data-state="add_state" class="action--state_button btn btn-primary  add-btn-modal">Добави</button>
    </div>
</form>