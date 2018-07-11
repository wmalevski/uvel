<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="addProductLabel">Редактиране на продукт</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="POST" name="edit" action="/products/{{ $product->id }}">
        <input name="_method" type="hidden" value="PUT">

        <div class="modal-body">

            <div class="info-cont">
            </div>
            {{ csrf_field() }}
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                        <input type="checkbox" id="inputCall1" name="with_stones" class="peer">
                        <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                            <span class="peer peer-greed">Тегло без камъни</span>
                        </label>
                    </div>
                </div>
                
                <div class="form-group col-md-6">
                    <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                        <input type="checkbox" id="inputCall2" name="for_wholesale" class="peer">
                        <label for="inputCall2" class="peers peer-greed js-sb ai-c">
                            <span class="peer peer-greed">За продажба на едро</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Модел: </label>
                    <select id="model_select_edit" name="model" class="model-select form-control model-filled">
                        <option value="">Избери</option>
                
                        @foreach($models as $model)
                            <option value="{{ $model->id }}" data-jewel="{{ App\Jewels::find($model->jewel)->id }}" @if($product->model == $model->id) selected @endif>{{ $model->name }}</option>
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
                    <select id="jewel_edit" name="jewelsTypes" class="form-control calculate" disabled>
                        <option value="">Избери</option>
                
                        @foreach($jewels as $jewel)
                        <option @if($product->jewel_type == $jewel->id) selected @endif value="{{ $jewel->id }}" data-pricebuy="@if(App\Prices::withTrashed()->where('material', $jewel->material)->where('type', 'buy')->first()){{App\Prices::withTrashed()->where('material', $jewel->material)->where('type', 'buy')->first()->price}}@endif" data-material="{{ $jewel->material }}">{{ $jewel->name }}</option>
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
                    <select id="material_edit" name="material" class="material_type form-control calculate">
                        <option value="">Избери</option>
                
                        @foreach($materials as $material)
                            <option value="{{ $material->id }}" @if($material->id == $product->material) selected @endif>{{ App\Materials::withTrashed()->find($material->material)->name }} - {{ App\Materials::withTrashed()->find($material->material)->color }} - {{ App\Materials::withTrashed()->find($material->material)->carat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Цена на дребно: </label>
                    <select id="retail_price_edit" name="retail_price" class="form-control calculate prices-filled retail-price" >
                        <option value="">Избери</option>
                
                        @foreach($prices->where('type', 'sell') as $price)
                            <option value="{{ $price->id }}" data-retail="{{ $price->price }}" data-material="{{ $price->material }}" @if($product->retail_price == $price->id) selected @endif>{{ $price->slug }} - {{ $price->price }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">            
                    <label>Цена на едро: </label>
                    <select id="wholesale_price_edit" name="wholesale_prices" class="form-control prices-filled wholesale-price">
                        <option value="">Избери</option>
                
                        @foreach($prices->where('type', 'sell') as $price)
                            <option value="{{ $price->id }}" data-material="{{ $price->material }}" @if($product->wholesale_price == $price->id) selected @endif>{{ $price->slug }} - {{ $price->price }}</option>
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
                <div class="form-group col-md-6 weight-holder-edit">
                    <label for="1">Тегло: </label>
                    <input type="text" class="form-control calculate" id="weight" value="{{ $product->weight }}" name="weight" placeholder="Тегло:" min="1" max="10000">
                </div>
            
                <div class="form-group col-md-6">
                    <label for="1">Размер: </label>
                    <input type="text" class="form-control" id="size" value="{{ $product->size }}" name="size" placeholder="Размер:" min="1" max="10000">
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
                                <option value="{{ $stone->id }}" @if($modelStone->stone == $stone->id) selected @endif>
                                    {{ App\Stones::find($stone->id)->name }} 

                                    ({{ App\Stone_contours::find($stone->contour)->name }}, {{ App\Stone_sizes::find($stone->size)->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="form-group col-md-4">
                        <label for="1">Брой: </label>
                        <input type="number" class="form-control" name="stone_amount[]" placeholder="Брой" value="{{  $modelStone->amount  }}" min="1" max="50">
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
                        <input type="number" class="form-control" name="stone_amount[]" placeholder="Брой" min="1" max="50">
                    </div>
                    <div class="form-group col-md-2">
                        <span class="delete-stone remove_field"><i class="c-brown-500 ti-trash"></i></span>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <button type="button" class="btn btn-primary add_field_button">Добави нов камък</button>

                <div class="col-12">
                    <hr>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="workmanship">Изработка: </label>
                    <div class="input-group"> 
                        <input type="number" class="form-control worksmanship_price" value="{{ $product->workmanship }}" name="workmanship" id="workmanship" value="0">
                        <span class="input-group-addon">лв</span>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="price">Цена: </label>
                    <div class="input-group"> 
                        <input type="number" class="form-control final_price" value="{{ $product->price }}" name="price" id="price" value="0">
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
                @foreach($photos as $photo)
                    <div class='image-wrapper'>
                        <div class='close'><span data-url="gallery/delete/{{$photo->id}}">&#215;</span></div>
                        <img src="{{ asset("uploads/products/" . $photo->photo) }}" alt="" class="img-responsive" />
                    </div>
                @endforeach 
            </div>

            <div id="errors-container"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" class="edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
</div>