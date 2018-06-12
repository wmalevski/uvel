<div class="editModalWrapper">
<div class="modal-header">
    <h5 class="modal-title" id="addProductLabel">Редактиране на продукт</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

    <form method="POST" name="edit" action="/productsothers/{{ $product->id }}">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">

            <div class="info-cont">
            </div>
            {{ csrf_field() }}

            <div class="form-group">
                <label for="1">Модел: </label>
                <input type="text" class="form-control" id="name" value="{{ $product->name }}" name="name" placeholder="Модел:">
            </div>
        
            <div class="form-group">
                <label>Тип: </label>
                <select id="type " name="type" class="form-control">
                    <option value="">Избери</option>
            
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" @if($type->id == $product->type) selected @endif>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="1">Цена: </label>
                <input type="text" class="form-control" id="price" value="{{ $product->price }}" name="price" placeholder="Цена на брой:">
            </div>

            <div class="form-group">
                <label for="1">Количество: </label>
                <input type="number" min="0" class="form-control" id="quantity" value="{{ $product->quantity }}" name="quantity" placeholder="Налично количество:" readonly>
            </div>

            <div class="form-group">
                <label for="1">Действие: </label>
                <select id="quantity_after" name="quantity_action" class="form-control">
                    <option value="add" selected="selected">Добави</option>
                    <option value="remove">Извади</option>
                </select>
            </div>

            <div class="form-group">
                <label for="1">Количество: </label>
                <input type="number" min="0" class="form-control" id="quantity_after" name="quantity_after" placeholder="Допълнително количество:">
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" class="edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
</div>