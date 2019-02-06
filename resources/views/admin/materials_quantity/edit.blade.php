<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="fullEditRepairLabel">Промени наличен материал</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <form method="POST" name="materialsQuantity" data-type="edit" action="mquantity/{{ $material->id }}">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">    
                <div class="info-cont">
                </div>
            {{ csrf_field() }}
    
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Тип: </label>
                    <select name="material_id" class="form-control" data-search="/ajax/select_search/materialstypes/">
                        <option value="">Избер материал</option>
                
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" @if($type->id == $material->material_id) selected @endif>{{ $type->parent->name }} - {{ $type->color }} - {{ $type->code }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="2">Количество: </label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="2" value="{{ $material->quantity }}" name="quantity" placeholder="Количество:" min="1">
                        <span class="input-group-addon">гр.</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Магазин: </label>
                <select name="store_id" class="form-control" data-search="/ajax/select_search/stores/">
                    <option value="">Избери магазин</option>
            
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" @if($store->id == $material->store_id) selected @endif>{{ $store->name }} - {{ $store->location }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
    </div>