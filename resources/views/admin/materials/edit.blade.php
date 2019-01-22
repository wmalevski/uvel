<div class="editModalWrapper">
<div class="modal-header">
    <h5 class="modal-title" id="addProductLabel">Редактиране на материал</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form method="POST" name="materials" data-type="edit" action="materials/{{ $material->id }}">
    <input name="_method" type="hidden" value="PUT">
    <div class="modal-body">
            
        <div class="info-cont">
        </div>
        {{ csrf_field() }}

        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Наследява: </label>
                <select name="parent_id" class="form-control">
                    <option value="">Избери материал: </option>
            
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" @if($parent->id == $material->parent->id) selected @endif>{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="2">Проба: </label>
                <input type="number" class="form-control" value="{{ $material->code }}" id="2" name="code" placeholder="Проба:">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="3">Цвят: </label>
                <input type="text" class="form-control" id="3" value="{{ $material->color }}" name="color" placeholder="Цвят:">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="3">Карат: </label>
                <input type="number" class="form-control" id="4" value="{{ $material->carat }}" name="carat" placeholder="Карати:">
            </div>
        </div>

        <div class="form-row mt-3">
                <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                    <input type="checkbox" id="weightWithStones" name="for_buy" class="peer" @if($material->for_buy == 'yes') checked @endif>
                    <label for="weightWithStones" class="peers peer-greed js-sb ai-c">
                        <span class="peer peer-greed">За изкупуване</span>
                    </label>
                </div>
            </div>

            <div class="form-row mt-3">
                <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                    <input type="checkbox" id="weightWithStones" name="for_exchange" class="peer" @if($material->for_exchange == 'yes') checked @endif>
                    <label for="weightWithStones" class="peers peer-greed js-sb ai-c">
                        <span class="peer peer-greed">За обмяна</span>
                    </label>
                </div>
            </div>

            <div class="form-row mt-3">
                <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                    <input type="checkbox" id="carat_transform" name="carat_transform" class="peer" @if($material->carat_transform == 'yes') checked @endif>
                    <label for="carat_transform" class="peers peer-greed js-sb ai-c">
                        <span class="peer peer-greed">Преобразуване на карати</span>
                    </label>
                </div>
            </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
    </div>
</form>
</div>
