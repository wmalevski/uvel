<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="editStoneLabel">Промяна на камък</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span> 
        </button>
    </div>

    <form method="POST" name="edit" action="/stones/{{ $stone->id }}">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">    
            <div class="info-cont">
            </div>

            {{ csrf_field() }}

            <select name="type" id="stone_type" class="form-control">
                <option value="1">Синтатичен</option>
                <option value="2">Естествен</option>
            </select>

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
        
            <label>Размер: </label>
            <select name="size" class="form-control">
                <option value="">Избер размер</option>
        
                @foreach($stone_sizes as $size)
                    <option value="{{ $size->id }}" @if($stone->size == $size->id) selected @endif>{{ $size->name }}</option>
                @endforeach
            </select>
        
            <label>Контур: </label>
            <select name="contour" class="form-control">
                <option value="">Избери контур</option> 
                    
                @foreach($stone_contours as $contour)
                    <option value="{{ $contour->id }}" @if($stone->contour == $contour->id) selected @endif>{{ $contour->name }}</option>
                @endforeach
            </select>
        
            <label>Стил: </label>
            <select name="style" class="form-control">
                <option value="">Избери стил</option>
        
                @foreach($stone_styles as $style)
                    <option value="{{ $style->id }}" @if($stone->style == $style->id) selected @endif>{{ $style->name }}</option>
                @endforeach
            </select>
            <br/>
        
            <div class="form-group">
                <label for="4">Количество: </label>
                <input type="number" class="form-control" value="{{ $stone->amount }}" id="4" name="amount" placeholder="Количество:">
            </div>
        
            <div class="form-group">
                <label for="5">Цена: </label>
                <input type="number" class="form-control" id="5" value="{{ $stone->price }}" name="price" placeholder="Цена:">
            </div>

            <div id="drop-area">
                <input type="file" name="images" id="fileElem" multiple accept="image/*" >
                <label class="button" for="fileElem">Select some files</label>
                <div id="gallery" /></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                <button type="submit" id="add" class="btn btn-primary" data-dismiss="modal">Промени</button>
            </div>
        </div>
    </form>
</div>