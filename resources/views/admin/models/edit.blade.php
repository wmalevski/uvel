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

        <label>Избери вид бижу: </label>
        <select id="jewel" name="jewel" class="form-control">
            <option value="">Избери</option>

            @foreach($jewels as $jewel)
                <option value="{{ $jewel->id }}" data-price="{{ $jewel->material }}" @if($model->jewel == $jewel->id) selected @endif>{{ $jewel->name }}</option>
            @endforeach
        </select>

        <label>Цена на дребно: </label>
        <select id="retail_price" name="retail_price" class="form-control">
            <option value="">Избери</option>

            @foreach($prices->where('type', 'sell') as $price)
                <option value="{{ $price->id }}" data-material="{{ $price->material }}" @if($model->retail_price == $price->id) selected @endif>{{ $price->slug }} - {{ $price->price }}</option>
            @endforeach
        </select>

        <label>Цена на едро: </label>
        <select name="wholesale_price" class="form-control">
            <option value="">Избери</option>

            @foreach($prices->where('type', 'sell') as $price)
                <option value="{{ $price->id }}" data-material="{{ $price->material }}" @if($model->wholesale_price == $price->id) selected @endif>{{ $price->slug }} - {{ $price->price }}</option>
            @endforeach
        </select>

        <div class="form-group">
            <label for="1">Тегло: </label>
            <input type="number" class="form-control" id="1" value="{{ $model->weight }}" name="weight" placeholder="Тегло:" min="0">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="edit" class="btn btn-primary" data-dismiss="modal">Промени</button>
    </div>
</form>