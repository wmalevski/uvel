<div class="editModalWrapper">
<div class="modal-header">
    <h5 class="modal-title" id="addProductLabel">Редактиране на модел</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form method="POST" name="models" data-type="edit" action="models/{{ $model->id }}">
    <input name="_method" type="hidden" value="PUT">
    <div class="modal-body">
            
        <div class="info-cont">
        </div>
        {{ csrf_field() }}
        
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="1">Име: </label>
                <input type="text" class="form-control" value="{{ $model->name }}" id="1" name="name" placeholder="Име:">
            </div>

            <div class="form-group col-md-6">
                <label>Избери вид бижу: </label>
                <select id="jewel_edit" name="jewel_id" class="form-control calculate">
                    <option value="">Избери</option>

                    @foreach($jewels as $jewel)
                        <option value="{{ $jewel->id }}" data-material="{{ $jewel->material_id }}" @if($model->jewel_id == $jewel->id) selected @endif>{{ $jewel->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-12">
                <hr>
            </div>
        </div>

        <div class="form-row model_materials">
            @if($options)
                @foreach($options as $option)
                <div class="form-row">
                    @if(!$loop->first)
                    <div class="col-md-12">
                        <div class="col-6">
                            <hr>
                        </div>
                    </div>
                    @endif
                    <div class="form-group col-md-6">
                        <label>Избери материал: </label>
                        <select id="material_type" name="material_id[]" class="material_type form-control calculate" data-calculatePrice-material>
                            <option value="">Избери</option>
                    
                            @foreach($materials as $material)
                                @if($material->material->pricesBuy->first() && $material->material->pricesSell->first())
                                    <option value="{{ $material->id }}" data-material="{{ $material->id }}" data-pricebuy="{{ $material->material->pricesBuy->first()->price }}" @if($material->id == $option->material_id) selected @endif>{{ $material->material->parent->name }} - {{ $material->material->color }} - {{ $material->material->carat }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-5">
                        <label>Цена: </label>
                        <select id="retail_price_edit" name="retail_price_id[]" class="form-control calculate prices-filled retail-price" data-calculatePrice-retail>
                            <option value="">Избери</option>
                            
                            @foreach($option->material->material->pricesSell as $price)
                                <option value="{{ $price->id }}" data-material="{{ $price->material_id }}" data-price="{{ $price->price }}" @if($option->retail_price_id == $price->id) selected @endif>{{ $price->slug }} - {{ $price->price }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if(!$loop->first)
                    <div class="form-group col-md-1">
                        <span class="delete-material remove_field" data-removeMaterials-remove><i class="c-brown-500 ti-trash"></i></span>
                    </div>
                    @endif

                    <div class="form-group col-md-12">
                        <div class="radio radio-info">
                            <input type="radio" class="default_material" id="" name="default_material[]" data-calculatePrice-default @if($option->default == 'yes') checked @endif>
                            <label for="">Материал по подразбиране</label>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        <div class="form-row">
            <button type="button" class="btn btn-primary add_field_variation" data-addMaterials-add>Добави нова комбинация</button>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-12">
                <hr>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-6 weight-holder">
                <label for="weight_edit">Нетно тегло: </label>
                <div class="input-group">
                    <input type="number" class="form-control calculate" id="weight_edit" value="{{ $model->weight }}" name="weight" data-calculatePrice-netWeight placeholder="Тегло:">
                    <span class="input-group-addon">гр</span>
                </div>
            </div>

            <div class="form-group col-md-6">
                <div class="form-group">
                    <label for="1">Размер: </label>
                    <input type="number" value="{{ $model->size }}" class="form-control" id="1" name="size" placeholder="Размер:">
                </div>
            </div>

            <div class="col-12">
                <hr>
            </div>
        </div>

        <div class="form-row model_stones">
            @foreach($modelStones as $modelStone)
            <div class="form-row fields">
                <div class="form-group col-md-6">
                    <label>Камък: </label>
                    
                        <select id="model-stone" name="stones[]" class="form-control" data-calculatePrice-stone>
                            <option value="">Избери</option>

                            @foreach($stones as $stone)
                                <option value="{{ $stone->id }}" @if($modelStone->stone->id == $stone->id) selected @endif data-stone-type="{{ $stone->type }}" data-stone-price="{{ $stone->price }}">
                                    {{ $modelStone->stone->name }} 

                                    ({{ $modelStone->stone->contour->name }}, {{ $modelStone->stone->style->name }})
                                </option>
                            @endforeach
                        </select>
                    
                </div>

                <div class="form-group col-md-4">
                    <label for="1">Брой: </label>
                    <input type="number" id="model-stone-number" class="form-control calculate-stones" name="stone_amount[]" data-calculateStones-amount placeholder="Брой" value="{{  $modelStone->amount  }}" min="1" max="50">
                </div>

                <div class="form-group col-md-2">
                    <span class="delete-stone remove_field" data-removeStone-remove><i class="c-brown-500 ti-trash"></i></span>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="1">Тегло: </label>
                        <div class="input-group">
                            <input type="number" value="{{  $modelStone->weight  }}" class="form-control calculate-stones" id="1" name="stone_weight[]" data-calculateStones-weight placeholder="Тегло:">
                            <span class="input-group-addon">гр</span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 stone-flow-holder"><input type="checkbox" id="inputCall1" name="stone_flow[]" class="peer stone-flow calculate-stones" @if($modelStone->flow == 'yes') checked @endif><label for="inputCall1" class="peers peer-greed js-sb ai-c"><span class="peer peer-greed">За леене</span></label>
                    <span class="row-total-weight"></span></div>
                </div>
            </div>
            @endforeach

        </div>

        <div class="form-row">
            <div class="form-group col-md-5">
                <button type="button" class="btn btn-primary add_field_button" data-addStone-add>Добави камък</button>
            </div>
            
            <div class="form-group col-md-3">
                <label for="totalStones_edit">Общо за леене:</label>
            </div>

            <div class="form-group col-md-4">
                <div class="input-group">
                    <input type="number" class="form-control" value="{{ $model->totalStones }}" id="totalStones_edit" name="totalStones" data-calculateStones-total disabled>
                    <span class="input-group-addon">гр</span>
                </div>
            </div>

            <div class="col-12">
                <hr>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Избработка:</label>
                <div class="input-group">
                    <input type="number" class="form-control worksmanship_price" value="{{ $model->workmanship }}" name="workmanship" data-calculatePrice-worksmanship>
                    <span class="input-group-addon">лв</span>
                </div>
            </div>
            
             <div class="form-group col-md-6">
                <label>Цена:</label>
                <div class="input-group">
                    <input type="number" class="form-control final_price" value="{{ $model->price }}" value="0" name="price" data-calculatePrice-final>
                    <span class="input-group-addon">лв</span>
                </div>
            </div>
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
        <button type="submit" id="edit" class="edit-btn-modal btn btn-primary">Промени</button>
    </div>
    
</form>
</div>

@section('footer-scripts')
<script id="stones_data" type="application/json">
 {!! $jsStones !!}
</script>

<script id="materials_data" type="application/json">
    {!! $jsMaterials !!}
</script>
@endsection
