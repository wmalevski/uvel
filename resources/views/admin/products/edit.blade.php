<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="addProductLabel">Редактиране на продукт</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="POST" name="products" data-type="edit" action="products/{{ $product->id }}">
        <input name="_method" type="hidden" value="PUT">

        <div class="modal-body">

            <div class="info-cont">
            </div>
            {{ csrf_field() }}
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                        <input type="checkbox" id="inputCall1" name="with_stones" class="peer" @if($product->weight_without_stones == 'yes') checked @endif>
                        <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                            <span class="peer peer-greed">Тегло без камъни</span>
                        </label>
                    </div>
                </div>
                
                <div class="form-group col-md-6">
                    <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                        <input type="checkbox" id="inputCall2" name="for_wholesale" class="peer" @if($product->for_wholesale == 'yes') checked @endif>
                        <label for="inputCall2" class="peers peer-greed js-sb ai-c">
                            <span class="peer peer-greed">За продажба на едро</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Модел: </label>
                    <select id="model_select_edit" name="model_id" class="model-select form-control model-filled" data-calculatePrice-model>
                        <option value="">Избери</option>
                
                        @foreach($models as $model)
                            <option value="{{ $model->id }}" data-jewel="{{ $model->jewel->id }}" @if($product->model->id == $model->id) selected @endif>{{ $model->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <hr>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Вид: </label>
                    <select id="jewel_edit" name="jewel_id" class="form-control jewels_types" data-modelFilled-jewel disabled>
                        <option value="">Избери</option>
                
                        @foreach($jewels as $jewel)
                        <option @if($product->jewel_id == $jewel->id) selected @endif value="{{ $jewel->id }}">{{ $jewel->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <hr>
                </div>
            </div>
            
            <div class="form-row model_materials">
                <div class="form-group col-md-12">
                    <label>Материал: </label>
                    <select id="material_edit" name="material_id" class="material_type form-control calculate" data-calculatePrice-material>
                        <option value="">Избери</option>
                
                        @foreach($materials as $material)
                            @if($material->material->pricesBuy->first() && $material->material->pricesSell->first())
                                <option value="{{ $material->id }}" data-material="{{ $material->material->id }}" data-pricebuy="{{ $material->material->pricesBuy->first()->price }}" @if($material->id == $product->material_id) selected @endif>{{ $material->material->parent->name }} - {{ $material->material->color }} - {{ $material->material->carat }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Цена на дребно: </label>
                    <select id="retail_price_edit" name="retail_price_id" class="form-control calculate prices-filled retail-price retail_prices" data-calculatePrice-retail>
                        <option value="">Избери</option>
                
                        @foreach($prices->where('type', 'sell') as $price)
                    <option value="{{ $price->id }}" data-retail="{{ $price->price }}" data-material="{{ $price->material }}" @if($product->retail_price_id == $price->id) selected @endif>{{ $price->slug }} - {{ $price->price }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">            
                    <label>Цена на едро: </label>
                    <select id="wholesale_price_edit" name="wholesale_price_id" class="form-control prices-filled wholesale-price wholesale_prices" data-calculatePrice-wholesale>
                        <option value="">Избери</option>
                
                        @foreach($prices->where('type', 'sell') as $price)
                            <option value="{{ $price->id }}" data-material="{{ $price->material }}" @if($product->wholesale_price_id == $price->id) selected @endif>{{ $price->slug }} - {{ $price->price }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <hr>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6 weight-holder weight-holder-edit">
                    <label for="1">Тегло: </label>
                    <input type="text" class="form-control weight calculate" id="weight" value="{{ $product->weight }}" name="weight" data-calculatePrice-weight placeholder="Тегло:" min="1" max="10000">
                </div>
            
                <div class="form-group col-md-6">
                    <label for="1">Размер: </label>
                    <input type="text" class="form-control size" id="size" value="{{ $product->size }}" name="size" data-modelFilld-size placeholder="Размер:" min="1" max="10000">
                </div>

                <div class="col-12">
                    <hr>
                </div>
            </div>

            <div class="form-row model_stones">
                @foreach($product_stones as $modelStone)
                <div class="form-row fields">
                    <div class="form-group col-md-6">
                        <label>Камъни: </label>
                        
                        <select name="stones[]" class="form-control">
                            <option value="">Избери</option>

                            @foreach($stones as $stone)
                                <option value="{{ $stone->id }}" @if($modelStone->stone_id == $stone->id) selected @endif>
                                    {{ $stone->name }}
                                    ({{ $stone->contour->name }}, {{ $stone->size->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="form-group col-md-4">
                        <label for="1">Брой: </label>
                        <input type="number" class="form-control calculate-stones" name="stone_amount[]" placeholder="Брой" value="{{  $modelStone->amount  }}" data-calculateStones-amount min="1" max="50">
                    </div>

                    <div class="form-group col-md-2">
                        <span class="delete-stone remove_field"><i class="c-brown-500 ti-trash"></i></span>
                    </div>

                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="1">Тегло: </label>
                            <input type="number" value="{{  $modelStone->weight  }}" class="form-control calculate-stones" id="1" name="stone_weight[]" data-calculateStones-weight placeholder="Тегло:" min="0.1" max="100">
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 stone-flow-holder">
                            <input type="checkbox" id="inputCall1" name="stone_flow[]" class="peer stone-flow calculate-stones" @if($modelStone->flow == 'yes') checked @endif>
                            <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                                <span class="peer peer-greed">За леене</span>
                            </label>
                            <span class="row-total-weight"></span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="form-row">
                <div class="form-group col-md-5">
                    <button type="button" class="btn btn-primary add_field_button" data-addStone-add>Добави камък</button>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="totalStones">Общо за леене:</label>
                </div>

                <div class="form-group col-md-4">
                    <input type="number" class="form-control" id="totalStones" name="totalStones" data-calculateStones-total disabled>
                </div>

                <div class="col-12">
                    <hr>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="workmanship">Изработка: </label>
                    <div class="input-group"> 
                        <input type="number" class="form-control worksmanship_price workmanship" value="{{ $product->workmanship }}" name="workmanship" id="workmanship" value="0" data-calculatePrice-worksmanship>
                        <span class="input-group-addon">лв</span>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="price">Цена: </label>
                    <div class="input-group"> 
                        <input type="number" class="form-control final_price price" value="{{ $product->price }}" name="price" id="price" value="0" data-calculatePrice-final>
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

            <div id="errors-container"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
</div>