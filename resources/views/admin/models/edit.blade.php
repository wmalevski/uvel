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
            <select id="jewel_edit" name="jewel" class="form-control calculate">
                <option value="">Избери</option>

                @foreach($jewels as $jewel)
                    <option value="{{ $jewel->id }}" data-material="{{ $jewel->material }}" data-pricebuy="@if(App\Prices::withTrashed()->where('material', $jewel->material)->where('type', 'buy')->first()){{App\Prices::withTrashed()->where('material', $jewel->material)->where('type', 'buy')->first()->price}}@endif" @if($model->jewel == $jewel->id) selected @endif>{{ $jewel->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Цена на дребно: </label>
            <select id="retail_price_edit" name="retail_price" class="form-control calculate prices-filled">
                <option value="">Избери</option>

                @foreach($prices->where('type', 'sell') as $price)
                    <option value="{{ $price->id }}" data-material="{{ $price->material }}" @if($model->retail_price == $price->id) selected @endif>{{ $price->slug }} - {{ $price->price }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Цена на едро: </label>
            <select id="wholesale_price_edit" name="wholesale_price" class="form-control prices-filled">
                <option value="">Избери</option>

                @foreach($prices->where('type', 'sell') as $price)
                    <option value="{{ $price->id }}" data-material="{{ $price->material }}" @if($model->wholesale_price == $price->id) selected @endif>{{ $price->slug }} - {{ $price->price }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="1">Тегло: </label>
            <input type="number" class="form-control calculate" id="weight" value="{{ $model->weight }}" name="weight" placeholder="Тегло:" min="0.1" max="10000">
        </div>

        <div class="model_stones">
            @foreach($modelStones as $modelStone)
            <div class="form-row fields">
                <div class="form-group col-md-6">
                    <label>Камъни: </label>
                    
                        <select name="stones[]" class="form-control">
                            <option value="">Избери</option>

                            @foreach($stones as $stone)
                                <option value="{{ $stone->id }}" @if($modelStone->stone == $stone->id) selected @endif>
                                    {{ App\Stones::find($stone->id)->name }} 

                                    ({{ App\Stone_contours::find($stone->contour)->name }}, {{ App\Stone_sizes::find($stone->size)->name }})
                                </option>
                            @endforeach
                        </select>
                    
                </div>

                <div class="form-group col-md-4">
                    <label for="1">Брой: </label>
                    <input type="number" id="model-stone-number" class="form-control" name="stone_amount[]" placeholder="Брой" value="{{  $modelStone->amount  }}" min="1" max="50">
                </div>

                <div class="form-group col-md-2">
                    <span class="delete-stone remove_field"><i class="c-brown-500 ti-trash"></i></span>
                </div>
            </div>
            @endforeach
            

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
                <div class="form-group col-md-4">
                    <label for="1">Брой: </label>
                    <input type="number" id="model-stone-number" class="form-control" name="stone_amount[]" placeholder="Брой" min="1" max="50">
                </div>
                <div class="form-group col-md-2">
                    <span class="delete-stone remove_field"><i class="c-brown-500 ti-trash"></i></span>
                </div>
            </div>
        </div>

        <div class="form-row form-group">
            <button type="button" class="btn btn-primary add_field_button">Добави нов камък</button>
        </div>

        {{-- <div class="model_stones">
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
                <div class="form-group col-md-4">
                    <label for="1">Брой: </label>
                    <input type="number" id="model-stone-number" class="form-control" name="stone_amount[]" placeholder="Брой" min="1" max="50">
                </div>
                <div class="form-group col-md-2">
                    <span class="delete-stone remove_field"><i class="c-brown-500 ti-trash"></i></span>
                </div>
            </div>
        </div> --}}
        



        <div class="form-row">
            <div class="form-group col-md-6">
                <div class="form-group">
                    <label>Избработка:</label>
                    <input type="number" class="form-control worksmanship_price" value="{{ $model->workmanship }}" name="workmanship">
                </div>
            </div>
            
             <div class="form-group col-md-6">
                <div class="form-group">
                    <label>Цена:</label>
                    <input type="number" class="form-control final_price" value="{{ $model->price }}" value="0" name="price">
                </div>
            </div>
        </div>

        <div class="drop-area" name="edit">
            <input type="file" name="images" class="drop-area-input" id="fileElem-edit" multiple accept="image/*" >
            <label class="button" for="fileElem-edit">Select some files</label>
            <div class="drop-area-gallery"></div>
        </div>

        <div class="uploaded-images-area">
        @foreach($photos as $photo)
            <div class='image-wrapper'>
                <div class='close'><span data-url="gallery/delete/{{$photo->id}}">&#215;</span></div>
                <img src="{{ asset("uploads/models/" . $photo->photo) }}" alt="" class="img-responsive" />
            </div>
        @endforeach 
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="edit" class="edit-btn-modal btn btn-primary">Промени</button>
    </div>
    
</form>
</div>