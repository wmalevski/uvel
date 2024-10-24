<div class="editModalWrapper">
<div class="modal-header">
    <h5 class="modal-title" id="addProductLabel">Редактиране на продукт</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

    <form method="POST" name="productsOthers" data-type="edit" action="productsothers/{{ $product->id }}">
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
                <select id="type " name="type_id" class="form-control">
                    <option value="">Избери</option>
            
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" @if($type->id == $product->type_id) selected @endif>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="1">Цена: </label>
                <div class="input-group">
                    <input type="text" class="form-control" id="price" value="{{ $product->price }}" name="price" placeholder="Цена на брой:">
                    <span class="input-group-addon">лв</span>
                </div>
            </div>

            <div class="form-group">
                <label for="1">Количество: </label>
                <div class="input-group">
                    <input type="number" min="0" class="form-control" id="quantity" value="{{ $product->quantity }}" name="quantity" placeholder="Налично количество:">
                    <span class="input-group-addon">бр.</span>
                </div>
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
                <div class="input-group">
                    <input type="number" min="0" class="form-control" id="quantity_after" name="quantity_after" placeholder="Допълнително количество:">
                    <span class="input-group-addon">бр.</span>
                </div>
            </div>

            <div class="form-group">
            <label>Магазин: </label>
                <select id="store" name="store_id" class="form-control">
                    <option value="">Избери</option>
            
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" @if($product->store_id == $store->id) selected @endif>{{ $store->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="drop-area" name="edit">
                    <input type="file" name="images" class="drop-area-input" id="fileElem-edit" multiple accept="image/*" >
                    <label class="button" for="fileElem-edit">Select some files</label>
                    <div class="drop-area-gallery"></div>
                </div>

            <div class="uploaded-images-area">
                    @foreach($basephotos as $photo)
                        <div class='image-wrapper'>
                            <div class='close'><span data-url="gallery/delete/{{$photo['id']}}">&#215;</span></div>
                            <img src="{{$photo['photo']}}" alt="" class="img-responsive" />
                        </div>
                    @endforeach 
                </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
</div>