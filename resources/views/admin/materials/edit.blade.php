<div class="editModalWrapper">
<div class="modal-header">
    <h5 class="modal-title" id="addProductLabel">Редактиране на материал</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form method="POST" name="edit" action="/materials/{{ $material->id }}">
    <input name="_method" type="hidden" value="PUT">
    <div class="modal-body">
            
        <div class="info-cont">
        </div>
        {{ csrf_field() }}

        <div class="form-row">
            <label>Наследява: </label>
            <select name="parent_id" class="form-control">
                <option value="">Избери материал: </option>
        
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" @if($parent->id == $material->parent->id) selected @endif>{{ $parent->name }}</option>
                @endforeach
            </select>
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
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="edit" class="edit-btn-modal btn btn-primary">Промени</button>
    </div>
</form>
</div>