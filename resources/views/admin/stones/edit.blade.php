<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="editStoneLabel">Промяна на камък</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span> 
        </button>
    </div>

    <form method="POST" id="edit-stones-form" name="edit" action="/stones/{{ $stone->id }}">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">    
            <div class="info-cont">
            </div>

            {{ csrf_field() }}

            <div class="form-group">
                <select name="type" id="stone_type" class="form-control">
                    <option value="1" @if($stone->type == 1) selected @endif>Синтетичен</option>
                    <option value="2" @if($stone->type == 2) selected @endif>Естествен</option>
                </select>
            </div>

            <div class="form-group">
                <label for="1">Име: </label>
                <input type="text" class="form-control" value="{{ $stone->name }}" id="1" name="name" placeholder="Име на камък:">
            </div>

            <div class="form-group">
                <label for="weight">Тегло: </label>
                <input type="number" class="form-control" value="{{ $stone->weight }}" id="weight" name="weight" placeholder="Тегло:">
            </div>
        
            <div class="form-group">
                <label for="carat">Карат: </label>
                <input type="number" class="form-control" id="carat" value="{{ $stone->carat }}" value="0" name="carat" placeholder="Карат:" >
            </div>
        
            <div class="form-group">
                <label>Размер: </label>
                <select name="size_id" class="form-control">
                    <option value="">Избер размер</option>
            
                    @foreach($stone_sizes as $size)
                        <option value="{{ $size->id }}" @if($stone->size_id == $size->id) selected @endif>{{ $size->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Контур: </label>
                <select name="contour_id" class="form-control">
                    <option value="">Избери контур</option> 
                        
                    @foreach($stone_contours as $contour)
                        <option value="{{ $contour->id }}" @if($stone->contour_id == $contour->id) selected @endif>{{ $contour->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Стил: </label>
                <select name="style_id" class="form-control">
                    <option value="">Избери стил</option>
            
                    @foreach($stone_styles as $style)
                        <option value="{{ $style->id }}" @if($stone->style_id == $style->id) selected @endif>{{ $style->name }}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="form-group">
                <label for="4">Количество: </label>
                <input type="number" class="form-control" value="{{ $stone->amount }}" id="4" name="amount" placeholder="Количество:">
            </div>
        
            <div class="form-group">
                <label for="5">Цена: </label>
                <input type="number" class="form-control" id="5" value="{{ $stone->price }}" name="price" placeholder="Цена:">
            </div>
            
            <div class="form-group">
                <label>Магазин: </label>
                <select name="store_id" class="form-control">
                    <option value="">Избери магазин</option>
            
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" @if($store->id == $stone->store_id) selected @endif>{{ $store->name }} - {{ $store->location }}</option>
                    @endforeach
                </select>
            </div>

            <div class="drop-area" name="edit">
                <input type="file" name="images" class="drop-area-input" id="fileElem-edit" multiple accept="image/*" >
                <label class="button" for="fileElem-edit">Select some files</label>
                <div class="drop-area-gallery"></div>
            </div>

            <div class="uploaded-images-area">
            @foreach($stone_photos as $photo)
                <div class='image-wrapper'>
                    <div class='close'><span data-url="gallery/delete/{{$photo->id}}">&#215;</span></div>
                    <img src="{{ asset("uploads/stones/" . $photo->photo) }}" alt="" class="img-responsive" />
                </div>
            @endforeach 
            </div>
          
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" class="edit-btn-modal btn btn-primary">Промени</button>
        </div>
        
    </form>
</div>