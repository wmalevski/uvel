<div class="addModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="addProductLabel">
            Добавяне на продукт
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="POST" name="products" data-type="add" action="products" autocomplete="off" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="info-cont"></div>
            {{ csrf_field() }}
            <div class="form-row">
                <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                    <input type="checkbox" id="weightWithStones" name="with_stones" class="peer"
                            data-calculatePrice-withStones>
                    <label for="weightWithStones" class="peers peer-greed js-sb ai-c">
                <span class="peer peer-greed">
                    Тегло с камъни
                </span>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>
                        Модел:
                    </label>
                    <select data-url="ajax/products/" name="model_id"
                            class="model-select form-control model-filled" data-calculatePrice-model
                            data-search="/ajax/select_search/models/">
                        <option value="">
                            Избери
                        </option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>
                        Вид:
                    </label>
                    <select name="jewel_id" class="jewels_types form-control" data-modelFilled-jewel
                            disabled data-search="/ajax/select_search/jewels/">
                        <option value="">
                            Избери
                        </option>
                    </select>
                </div>
                <div class="col-12">
                    <hr>
                </div>
            </div>

            <div class="form-row model_materials">
                <div class="form-group col-md-12">
                    <label>
                        Материал:
                    </label>
                    <select name="material_id" class="material_type form-control material calculate"
                            data-calculatePrice-material disabled
                            data-search="/ajax/select_search/global/materials/">
                        <option value="">
                            Избери
                        </option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>
                        Цена:
                    </label>
                    <select id="retail_prices" name="retail_price_id"
                            class="form-control calculate prices-filled retail-price retail_prices"
                            data-calculatePrice-retail disabled>
                        <option value="">
                            Избери
                        </option>

                        @foreach($prices as $price)
                            <option value="{{ $price->id }}" data-retail="{{ $price->price }}"
                                    data-material="{{ $price->material }}">
                                {{ $price->slug }} - {{ $price->price }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3 weight-holder">
                    <label for="weight">
                        Нетно тегло:
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control weight calculate" id="weight"
                                name="weight"
                                data-calculatePrice-netWeight placeholder="Тегло:" min="1" max="10000">
                        <span class="input-group-addon">гр.</span>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="size">
                        Размер:
                    </label>
                    <input type="text" class="form-control size" id="size" name="size"
                            placeholder="Размер:" min="1" data-modelFilld-size max="10000">
                </div>

                <div class="col-12">
                    <hr>
                </div>
            </div>

            <div class="model_stones"></div>

            <div class="form-row">
                <div class="form-group col-md-6 mt-auto">
                    <button type="button" class="btn btn-primary add_field_button" data-addStone-add>
                        Добави камък
                    </button>
                </div>

                <div class="form-group col-md-6">
                    <label for="totalStones">
                        Общо за леене:
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="totalStones" name="totalStones"
                                data-calculateStones-total disabled>
                        <span class="input-group-addon">гр.</span>
                    </div>
                </div>

                <div class="col-12">
                    <hr>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="grossWeight">
                        Брутно тегло:
                    </label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="gross_weight" id="grossWeight"
                                value="0" data-calculatePrice-grossWeight disabled>
                        <span class="input-group-addon">гр.</span>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="workmanship">
                        Изработка:
                    </label>
                    <div class="input-group">
                        <input type="number" class="form-control workmanship worksmanship_price"
                                name="workmanship" id="workmanship"
                                value="0" data-calculatePrice-worksmanship>
                        <span class="input-group-addon">
                    лв
                </span>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="price">Цена: </label>
                    <div class="input-group">
                        <input type="number" class="form-control final_price price" name="price"
                                id="price" value="0" data-calculatePrice-final>
                        <span class="input-group-addon">
                    лв
                </span>
                    </div>
                </div>

                <div class="col-12">
                    <hr>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>
                        Магазин:
                    </label>
                    @if($loggedUser->role != 'storehouse')
                        <select name="store_id" class="store-select form-control"
                                data-search="/ajax/select_search/stores/">
                                <option value="{{ $stores->first()->id }}">{{ $stores->first()->name }} - {{ $stores->first()->location }}</option>
                        </select>
                    @else
                        {{ $stores->first()->name }} - {{ $stores->first()->location }}
                    @endif
                </div>

                <div class="col-12">
                    <hr>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="1">Снимка: </label>
                    <div class="drop-area form-row justify-content-between" name="add">
                        <input type="file" name="images[]" class="drop-area-input" id="images" accept="image/*" multiple>
                        <label class="button" for="images">{{__("Избери снимка")}}</label>
                        <div class="drop-area-gallery">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row bot-row">
                <div class="form-group col-md-6">
                    <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 mt-3">
                        <input type="checkbox" id="website_visible" name="website_visible" class="peer"
                                checked>
                        <label for="website_visible" class="peers peer-greed js-sb ai-c">
                    <span class="peer peer-greed">
                        Показване в сайта
                    </span>
                        </label>
                    </div>
                </div>
            </div>

            <div id="errors-container"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                Затвори
            </button>
            <button type="submit" id="add" data-state="add_state"
                    class="action--state_button add-btn-modal btn btn-primary">
                Добави
            </button>
        </div>
    </form>
</div>