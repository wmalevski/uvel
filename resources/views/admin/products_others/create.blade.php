<div class="modal-header">
    <h5 class="modal-title" id="addProductLabel">Добавяне на продукт</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form method="POST" name="productsOthers" data-type="add" action="productsothers" autocomplete="off" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="info-cont">
        </div>
        {{ csrf_field() }}

        <div class="form-group">
            <label for="1">Модел: </label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Модел:">
        </div>
    
        <div class="form-group">
            <label>Тип: </label>
            <select id="type" name="type_id" class="form-control">
                <option value="">Избери</option>
        
                @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="1">Цена: </label>
            <div class="input-group">
                <input type="number" class="form-control" id="price" name="price" placeholder="Цена на брой:">
                <span class="input-group-addon">лв</span>
            </div>
        </div>

        <div class="form-group">
            <label for="1">Количество: </label>
            <div class="input-group">
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Налично количество:">
                <span class="input-group-addon">бр.</span>
            </div>
        </div>

        <div class="form-group">
            <label>Магазин: </label>
            <select id="store " name="store_id" class="form-control">
        
                @foreach($stores as $store)
                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="drop-area" name="add">
            <input type="file" name="images[]" class="drop-area-input" id="fileElem-add" multiple accept="image/*" >
            <label class="button" for="fileElem-add">Select some files</label>
            <div class="drop-area-gallery"></div>
        </div>


    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="add" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
    </div>
</form>