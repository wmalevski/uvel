@extends('admin.layout')

@section('content')

<div class="modal fade" id="addModel"   role="dialog" aria-labelledby="addModelLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModelLabel">Добавяне на модел</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/models" name="addModel" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="1">Име: </label>
                            <input type="text" class="form-control" id="1" name="name" placeholder="Име:">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Избери вид бижу: </label>
                            <select id="jewel_id" name="jewel" class="form-control calculate">
                                <option value="0">Избери</option>
                        
                                @foreach($jewels as $jewel)
                                    <option value="{{ $jewel->id }}">{{ $jewel->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <hr>
                        </div>
                    </div>
                    <div class="form-row model_materials">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Избери материал: </label>
                                <select id="material_type" name="material_id[]" class="material_type form-control calculate">
                                    <option value="0">Избери</option>
                            
                                    @foreach($materials as $material)
                                        <option value="{{ $material->id }}" data-material="{{ $material->material }}" data-pricebuy="{{ App\Price::where([['material', '=', $material->material], ['type', '=', 'buy']])->first()->price}}">{{ $material->parent->name }} - {{ $material->parent->color }} - {{ $material->parent->carat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Цена на дребно: </label>
                                <select id="retail_prices" name="retail_price_id[]" class="form-control calculate prices-filled retail-price" disabled>
                                    <option value="0">Избери</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Цена на едро: </label>
                                <select id="wholesale_price" name="wholesale_price_id[]" class="form-control prices-filled wholesale-price" disabled>
                                    <option value="0">Избери</option>
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <div class="radio radio-info">
                                    <input type="radio" class="default_material" id="" name="default_material[]" checked>
                                    <label for="">Материал по подразбиране</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <button type="button" class="btn btn-primary add_field_variation">Добави нова комбинация</button>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <hr>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 weight-holder">
                            <label for="1">Тегло: </label>
                            <input type="number" class="form-control calculate" id="weight" name="weight" placeholder="Тегло:">
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="1">Размер: </label>
                                <input type="number" class="form-control" id="1" name="size" placeholder="Размер:">
                            </div>
                        </div>

                        <div class="col-12">
                            <hr>
                        </div>
                    </div>

                    <div class="from-row model_stones">
                        <!-- <div class="form-row fields">
                            <div class="form-group col-md-6">
                                <label>Камък: </label>
                                <select id="model-stone" name="stones[]" class="form-control">
                                    <option value="">Избери</option>

                                    @foreach($stones as $stone)
                                        <option value="{{ $stone->id }}">
                                            {{ $stone->name }} ({{ $stone->contour->name }}, {{ $stone->style->name }})
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
                            <div class="form-group col-md-6">
                                <div class="form-group">
                                    <label>Тегло: </label>
                                    <input type="number" class="form-control" name="stone_weight[]" placeholder="Тегло:" min="0.1" max="100">
                                </div>
                            </div>
    
                            <div class="form-group col-md-6">
                                <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 stone-flow-holder">
                                    <input type="checkbox" id="" class="stone-flow" name="stone_flow[]" class="peer">
                                    <label for="" class="peers peer-greed js-sb ai-c">
                                        <span class="peer peer-greed">За леене</span>
                                    </label>
                                </div>
                            </div>
                        </div> -->
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <button type="button" class="btn btn-primary add_field_button">Добави камък</button>
                        </div>
                        
                        <div class="form-group col-md-3">
                            <label for="totalStones">Общо за леене:</label>
                        </div>

                        <div class="form-group col-md-4">
                            <input type="number" class="form-control" id="totalStones" name="totalStones" disabled>
                        </div>

                        <div class="col-12">
                            <hr>
                        </div>
                    </div>

                    <br/>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Избработка:</label>
                            <div class="input-group">
                                <input id="workmanship" type="number" class="form-control worksmanship_price" value="0" name="workmanship">
                                <span class="input-group-addon">лв</span>
                            </div>
                        </div>
                        
                         <div class="form-group col-md-6">
                            <label>Цена:</label>
                            <div class="input-group">
                                <input id="price" type="number" class="form-control final_price" value="0" name="price">
                                <span class="input-group-addon">лв</span>
                            </div>
                        </div>
                    </div>

                    <div class="drop-area" name="add">
                        <input type="file" name="images" class="drop-area-input" id="fileElem-add" multiple accept="image/*" >
                        <label class="button" for="fileElem-add">Select some files</label>
                        <div class="drop-area-gallery"></div>
                    </div>

                    <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15 mt-3">
                        <input type="checkbox" id="inputCall1" name="release_product" class="peer">
                        <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                            <span class="peer peer-greed">Добави като продукт</span>
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" class="add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editModel" role="dialog" aria-labelledby="editModelLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModelLabel">Редактиране на модел</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="info-cont">
                </div>
                {{ csrf_field() }}


            </div>
        </div>
    </div>
</div>

<h3>Модели <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#addModel">Добави</button></h3>

<table class="table table-condensed models-table">
    <tr>
        <th>Име</th> 
        <th>Виж бижу</th>
        <th>Тегло</th>
        <th>Изработка</th>
        <th>Цена</th>
        <th>Действия</th>
    </tr>
    
    @foreach($models as $model)
        @include('admin.models.table')
    @endforeach
</table>
@endsection

@section('footer-scripts')
<script id="stones_data" type="application/json">
 {!! $jsStones !!}
</script>

<script id="materials_data" type="application/json">
    {!! $jsMaterials !!}
</script>
@endsection
