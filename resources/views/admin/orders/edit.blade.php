@php
$givenMaterialRowTpl = '<div class="form-row">
						<div class="form-group col-md-6"> 
							<label for="">Вид</label>
							<select name="given_material_id[]" data-calculateprice-material class="material_type form-control calculate" data-search="/ajax/select_search/global/materials/">
								<option value="">Избери</option>';
								foreach($materials as $material) {
									if($material->pricesBuy->first() && $material->pricesSell->first()) {
									$givenMaterialRowTpl .= '<option value="'. $material->id .'" data-carat="'. $material->carat  .'" data-material="'. $material->id  .'"
										data-pricebuy="'. $material->pricesBuy->first()->price  .'"> 
										'. $material->parent->name  .' - 
										'. $material->color  .' - 
										'. $material->carat  .' 
									</option>';
									}
								}
							$givenMaterialRowTpl .= '</select>
						</div>
						<div class="form-group col-md-5">
							<label for="grossWeight">Количество:</label>
							
							<div class="input-group">
								<input type="number" class="form-control mat-quantity" name="mat_quantity[]" placeHolder="0">
							</div>
            </div>
            <div class="form-group col-md-1">
							<span class="delete-material remove_field" data-materials-remove><i class="c-brown-500 ti-trash"></i></span>
						</div>
					</div>';

$givenMaterialRowTpl = str_replace("\n", "", str_replace("\r", "", $givenMaterialRowTpl));
@endphp
<div class="editModalWrapper">
  <div class="modal-header">
    <h5 class="modal-title" id="addorderLabel">Редактиране на поръчка</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <form method="POST" name="orders" data-type="edit" action="orders/{{ $order->id }}">
    <input name="_method" type="hidden" value="PUT">
    <div class="modal-body">
      <div class="info-cont"></div>
      {{ csrf_field() }}
      
      <div class="form-row">
        <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
          <input id="weightWithStones_edit" class="peer" type="checkbox" name="with_stones"
                 data-calculatePrice-withStones @if($order->weight_without_stones == 'yes') checked @endif >
          <label for="weightWithStones_edit" class="peers peer-greed js-sb ai-c">
            <span class="peer peer-greed">Тегло с камъни</span>
          </label>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="weight">Сканирай продукт:</label>
          
          <div class="input-group">
            <input id="calculate_product" class="form-control" type="text" data-url="ajax/orders/getProductInfo/"
                   name="product_id" placeholder="Сканирай продукт:">
          </div>
        </div>
        
        <div class="col-12">
          <hr>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Модел:</label>
          
          <select data-url="ajax/orders/getModelInfo/" id="model_select_edit" name="model_id" class="model-select form-control model-filled" data-calculatePrice-model data-search="/ajax/select_search/models/">
            <option value="">Избери</option>
            @foreach($models as $model)
            <option value="{{ $model->id }}" data-jewel="{{ $model->jewel->id }}"
                    @if($order->model->id == $model->id) selected @endif>
              {{ $model->name }}
            </option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-6">
          <label>Вид:</label>
          
          <select id="jewel_edit" name="jewel_id" class="form-control jewels_types" data-modelFilled-jewel disabled data-search="/ajax/select_search/jewels/">
            <option value="">Избери</option>
            
            @foreach($jewels as $jewel)
            <option @if($order->jewel_id == $jewel->id) selected @endif value="{{ $jewel->id }}">
              {{ $jewel->name }}
            </option>
            @endforeach
          </select>
        </div>
        
        <div class="col-12">
          <hr>
        </div>
      </div>

      <div class="form-row model_materials">
        <div class="form-group col-md-12">
          <label>Материал:</label>
          
          <select id="material_edit" name="material_id" class="material_type form-control calculate" data-calculatePrice-material data-search="/ajax/select_search/global/materials/">
            <option value="">Избери</option>
            
            @foreach($materials as $material)
              @if($material->pricesBuy->first() && $material->pricesSell->first())
                <option value="{{ $material->id }}" data-material="{{ $material->id }}"
                        data-pricebuy="{{ $material->pricesBuy->first()->price }}"
                        @if($material->id == $order->material_id) selected @endif>
                  {{ $material->parent->name }} -
                  {{ $material->color }} -
                  {{ $material->carat }}
                </option>
              @endif
            @endforeach
          </select>
        </div>
        
        <div class="form-group col-md-6">
          <label>Цена:</label>
          
          <select id="retail_price_edit" class="form-control calculate prices-filled retail-price retail_prices"
                  name="retail_price_id" data-calculatePrice-retail>
            <option value="">Избери</option>

            @foreach($prices->where('type', 'sell') as $price)
            <option value="{{ $price->id }}" data-retail="{{ $price->price }}" data-material="{{ $price->material }}"
                    @if($order->retail_price_id == $price->id) selected @endif>
              {{ $price->slug }} - {{ $price->price }}
            </option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-3 weight-holder weight-holder-edit">
          <label for="weight_edit">Нетно тегло:</label>
          
          <div class="input-group">
            <input id="weight_edit" class="form-control weight calculate" type="text" value="{{ $order->weight }}"
                   name="weight" data-calculatePrice-netWeight placeholder="Тегло:" min="1" max="10000">
            <span class="input-group-addon">гр</span>
          </div>
        </div>

        <div class="form-group col-md-3">
          <label for="size_edit">Размер:</label>
          
          <input type="text" class="form-control size" id="size_edit" value="{{ $order->size }}" name="size"
                 data-modelFilld-size placeholder="Размер:" min="1" max="10000">
        </div>
        
        <div class="col-12">
          <hr>
        </div>
      </div>

      <div class="model_stones">
        @foreach($order->stones as $order_stone)
        <div class="form-row fields">
          <div class="form-group col-md-6">
            <label>Камъни:</label>

            <select name="stones[]" class="form-control" data-calculatePrice-stone data-search="/ajax/select_search/stones/">
              <option value="">Избери</option>

              @foreach($stones as $stone)
              <option value="{{ $stone->id }}" @if($order_stone->stone_id == $stone->id) selected @endif
                      data-stone-type="{{ $stone->type }}" data-stone-price="{{ $stone->price }}">
                {{ $stone->name }}
                ({{ $stone->contour->name }}, 
                {{ $stone->size->name }})
              </option>
              @endforeach
            </select>
          </div>

          <div class="form-group col-md-4">
            <label for="1">Брой:</label>
            
            <input type="number" class="form-control calculate-stones" name="stone_amount[]" placeholder="Брой" value="{{  $order_stone->amount  }}"
                   data-calculateStones-amount min="1" max="50">
          </div>

          <div class="form-group col-md-2">
            <span class="delete-stone remove_field">
              <i class="c-brown-500 ti-trash"></i>
            </span>
          </div>

          <div class="form-group col-md-6">
            <div class="form-group">
              <label for="1">Тегло:</label>
              
              <div class="input-group">
                <input type="number" value="{{  $order_stone->weight  }}" class="form-control calculate-stones" id="1"
                       name="stone_weight[]" data-calculateStones-weight placeholder="Тегло:" min="0.1" max="100">
                <span class="input-group-addon">гр</span>
              </div>
            </div>
          </div>

          <div class="form-group col-md-6">
            <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 stone-flow-holder">
              <input type="checkbox" id="inputCall1" name="stone_flow[]" class="peer stone-flow calculate-stones"
                     @if($order_stone->flow == 'yes') checked @endif>
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
        <div class="form-group col-md-6 mt-auto">
          <button type="button" class="btn btn-primary add_field_button" data-addStone-add>
            Добави камък
          </button>
        </div>

        <div class="form-group col-md-6">
          <label for="totalStones_edit">Общо за леене:</label>
          
          <div class="input-group">
            <input type="number" class="form-control" id="totalStones" name="totalStones_edit" data-calculateStones-total disabled>
            <span class="input-group-addon">гр</span>
          </div>
        </div>

        <div class="col-12">
          <hr>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="grossWeight_edit">Брутно тегло:</label>
          
          <div class="input-group">
            <input id="grossWeight_edit" class="form-control" type="number" name="gross_weight"
                   value="{{ $order->gross_weight }}" data-calculatePrice-grossWeight disabled>
            <span class="input-group-addon">гр</span>
          </div>
        </div>

        <div class="form-group col-md-4">
          <label for="workmanship">Изработка:</label>
          
          <div class="input-group">
            <input id="workmanship" class="form-control worksmanship_price workmanship" type="number"
                   value="{{ $order->workmanship }}" name="workmanship" value="0" data-calculatePrice-worksmanship>
            <span class="input-group-addon">лв</span>
          </div>
        </div>

        <div class="form-group col-md-4">
          <label for="price">Цена:</label>
          
          <div class="input-group">
            <input type="number" class="form-control final_price price" value="{{ $order->price }}"
                   name="price" id="price" value="0" data-calculatePrice-final>
            <span class="input-group-addon">лв</span>
          </div>
        </div>
        
        <div class="col-12">
          <hr>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-12">
          <label>Магазин:</label>
          
          <select name="store_id" class="form-control" data-search="/ajax/select_search/stores/">
            <option value="">Избери магазин</option>

            @foreach($stores as $store)
            <option value="{{ $store->id }}" @if($store->id == $order->store_id) selected @endif>
              {{ $store->name }} - {{ $store->location }}
            </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="grossWeight">Бройка:</label>
          
          <div class="input-group">
            <input type="number" class="form-control" name="quantity" id="quantity" value="{{ $order->quantity }}">
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="grossWeight">Описание:</label>
          
          <div class="input-group">
            <textarea class="form-control" name="content" id="notes" placeholder="Описание на поръчката"></textarea>
          </div>
        </div>
        
        <div class="col-12">
          <hr>
        </div>
      </div>
      
      <div class="given-material">
					<div class="form-row">
						<div class="form-group col-md-12">
							<strong>Даден материал:</strong>
						</div>
					</div>
          @foreach($order->materials as $material)
          <div class="form-row">
            <div class="form-group col-md-6"> 
              <label for="">Вид</label>
              <select name="given_material_id[]" data-calculateprice-material class="material_type form-control calculate" data-search="/ajax/select_search/global/materials/">
                <option value="">Избери</option>
                  @if($material->material->material->pricesBuy->first())
                  <option value="{{ $material->material->id }} " data-carat="{{ $material->material->material->carat  }}" data-material="{{ $material->material->material->id  }}"
                    data-pricebuy="{{ $material->material->material->pricesBuy->first()->price }}" selected> 
                    {{ $material->material->material->parent->name }}  - 
                    {{ $material->material->material->color }}  - 
                    {{ $material->material->material->code }}   
                  </option>
                  @endif
              </select>
            </div>
            <div class="form-group col-md-5">
              <label for="grossWeight">Количество:</label>
              
              <div class="input-group">
                <input type="number" class="form-control mat-quantity" name="mat_quantity[]" value="{{ $material->weight }}" placeHolder="0">
              </div>
            </div>
            <div class="form-group col-md-1">
                <span class="delete-material remove_field" data-materials-remove><i class="c-brown-500 ti-trash"></i></span>
            </div>
          </div>
        @endforeach
      </div>
   
      <div class="form-row pt-3">
          <div class="form-group col-md-6 mt-auto">
            <button id="btnAddAnother" class="action--state_button add-btn-modal btn btn-primary">
              Добави друг
            </button>
          </div>
          
          <div class="col-12">
            <hr>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="grossWeight">Капаро:</label>
            
            <div class="input-group">
              <input type="number" class="form-control" name="earnest" id="earnest" placeholder="0" value="{{ $order->earnest }}">
            </div>
          </div>

          <div class="form-group col-md-6">
            <label for="grossWeight">Фискален бон:</label>

            <button class="action--state_button add-btn-modal btn btn-primary" data-manual-receipt>
              Ръчно пускане на фискален бон
            </button>
          </div>
        </div>

      <div class="form-row pt-3">
        <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
          <input type="checkbox" id="inputCall1" name="status" class="peer" value="ready"
                 @if($order->status == 'ready') checked @endif>
          <label for="inputCall1" class="peers peer-greed js-sb ai-c">
            <span class="peer peer-greed">Готов за връщане</span>
          </label>
        </div>
      </div>
    
    </div>
    
    <div id="errors-container"></div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">
        Затвори
      </button>
      <button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">
        Промени
      </button>
    </div>
  </form>
</div>

<script>
  var givenMaterialRow = '{!! $givenMaterialRowTpl !!}';
</script>
