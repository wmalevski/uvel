<div class="editModalWrapper">
<div class="modal-header">
    <h5 class="modal-title" id="addProductLabel">Редактиране на модел</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form method="POST" name="edit" action="/models/{{ $model->id }}">
    <input name="_method" type="hidden" value="PUT">
    <div class="modal-body">
            
        <div class="info-cont">
        </div>
        {{ csrf_field() }}

        <div class="form-group">
            <label for="1">Име: </label>
            <input type="text" class="form-control" value="{{ $model->name }}" id="1" name="name" placeholder="Име:">
        </div>

        <div class="form-group">
            <label>Избери вид бижу: </label>
            <select id="jewel" name="jewel" class="form-control">
                <option value="">Избери</option>

                @foreach($jewels as $jewel)
                    <option value="{{ $jewel->id }}" data-price="{{ $jewel->material }}" @if($model->jewel == $jewel->id) selected @endif>{{ $jewel->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Цена на дребно: </label>
            <select id="retail_price" name="retail_price" class="form-control">
                <option value="">Избери</option>

                @foreach($prices->where('type', 'sell') as $price)
                    <option value="{{ $price->id }}" data-material="{{ $price->material }}" @if($model->retail_price == $price->id) selected @endif>{{ $price->slug }} - {{ $price->price }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Цена на едро: </label>
            <select name="wholesale_price" class="form-control">
                <option value="">Избери</option>

                @foreach($prices->where('type', 'sell') as $price)
                    <option value="{{ $price->id }}" data-material="{{ $price->material }}" @if($model->wholesale_price == $price->id) selected @endif>{{ $price->slug }} - {{ $price->price }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="1">Тегло: </label>
            <input type="number" class="form-control" id="1" value="{{ $model->weight }}" name="weight" placeholder="Тегло:" min="0.1" max="10000">
        </div>

        <div class="model_stones2">
            <div class="form-row fields2">
                <div class="form-group col-md-6">
                    <label>Камъни: </label>
                    @foreach($modelStones as $modelStone)
                        <select name="stones[]" class="form-control">
                            <option value="">Избери</option>

                            @foreach($stones as $stone)
                                <option value="{{ $stone->id }}" @if($modelStone->stone == $stone->id) selected @endif>
                                    {{ App\Stones::find($stone->id)->name }} 

                                    ({{ App\Stone_contours::find($stone->contour)->name }}, {{ App\Stone_sizes::find($stone->size)->name }})
                                </option>
                            @endforeach
                        </select>
                    @endforeach
                </div>
                <div class="form-group col-md-6">
                        <label for="1">Брой: </label>
                @foreach($modelStones as $modelStone)
                    <input type="number" class="form-control" value="{{ $modelStone->amount }}" name="stone_amount[]" placeholder="Брой" min="1" max="50">
                @endforeach
            </div>
            </div>
        </div>

        <div class="model_stones">
            <div class="form-row fields">
                <div class="form-group col-md-6">
                    <label>Камък: </label>
                    <select name="stones[]" class="form-control">
                        <option value="">Избери</option>

                        @foreach($stones as $stone)
                            <option value="{{ $stone->id }}">
                                {{ $stone->name }} ({{ App\Stone_contours::find($stone->contour)->name }}, {{ App\Stone_sizes::find($stone->size)->name }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="1">Брой: </label>
                    <input type="number" class="form-control" name="stone_amount[]" placeholder="Брой" min="1" max="50">
                </div>
            </div>
        </div>
        

        <div class="form-row">
            <button type="button" class="btn btn-primary add_field_button">Добави нов камък</button>
        </div>

        <div class="drop-area" name="edit">
            <input type="file" name="images" class="drop-area-input" id="drop-area-models" multiple accept="image/*" >
            <label class="button" for="drop-area-models">Select some files</label>
            <div class="drop-area-gallery"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" class="edit-btn-modal btn btn-primary" data-dismiss="modal">Промени</button>
        </div>
    </div>
</form>
</div>