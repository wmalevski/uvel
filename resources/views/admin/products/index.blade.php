@extends('admin.layout')

@section('content')
<div class="modal fade" id="addProduct"   role="dialog" aria-labelledby="addProductlLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductLabel">Добавяне на продукт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="products" action="/products" autocomplete="off">
                <div class="modal-body">

                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}

                    <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                        <input type="checkbox" id="inputCall1" name="with_stones" class="peer">
                        <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                            <span class="peer peer-greed">Тегло без камъни</span>
                        </label>
                    </div>

                    <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                        <input type="checkbox" id="for_wholesale" name="for_wholesale" class="peer">
                        <label for="inputCall2" class="peers peer-greed js-sb ai-c">
                            <span class="peer peer-greed">За продажба на едро</span>
                        </label>
                    </div>
                
                    <div class="form-group">
                        <label>Модел: </label>
                        <select id="model_select" name="model" class="form-control model-filled">
                            <option value="">Избери</option>
                    
                            @foreach($models as $model)
                                <option value="{{ $model->id }}" data-jewel="{{ App\Jewels::withTrashed()->find($model->jewel)->id }}">{{ $model->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Вид: </label>
                        <select id="jewels_types" name="jewelsTypes" class="form-control calculate">
                            <option value="">Избери</option>
                    
                            @foreach($jewels as $jewel)
                                <option value="{{ $jewel->id }}" data-pricebuy="@if(App\Prices::withTrashed()->where('material', $jewel->material)->where('type', 'buy')->first()){{App\Prices::withTrashed()->where('material', $jewel->material)->where('type', 'buy')->first()->price}}@endif" data-material="{{ $jewel->material }}">{{ $jewel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Цена на дребно: </label>
                        <select id="retail_prices" name="retail_price" class="form-control calculate prices-filled">
                            <option value="">Избери</option>
                    
                            @foreach($prices->where('type', 'sell') as $price)
                                <option value="{{ $price->id }}" data-retail="{{ $price->price }}" data-material="{{ $price->material }}">{{ $price->slug }} - {{ $price->price }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Цена на едро: </label>
                        <select id="wholesale_prices" name="wholesale_prices" class="form-control prices-filled">
                            <option value="">Избери</option>
                    
                            @foreach($prices->where('type', 'sell') as $price)
                                <option value="{{ $price->id }}" data-material="{{ $price->material }}">{{ $price->slug }} - {{ $price->price }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group weight-holder">
                        <label for="1">Тегло: </label>
                        <input type="text" class="form-control calculate" id="weight" name="weight" placeholder="Тегло:" min="1" max="10000">
                    </div>
                
                    <div class="form-group">
                        <label for="1">Размер: </label>
                        <input type="text" class="form-control" id="size" name="size" placeholder="Размер:" min="1" max="10000">
                    </div>

                    <div class="model_stones">
                        <div class="form-row fields">
                            <div class="form-group col-md-6">
                                <label>Камък: </label>
                                <select name="stones[]" class="form-control">
                                    <option value="">Избери</option>

                                    @foreach($stones as $stone)
                                        <option value="{{ $stone->id }}">
                                            {{ $stone->name }} ({{ App\Stone_contours::withTrashed()->find($stone->contour)->name }}, {{ App\Stone_sizes::withTrashed()->find($stone->size)->name }})
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

                    <div class="form-group form-row">
                        <button type="button" class="btn btn-primary add_field_button">Добави нов камък</button>
                    </div>

                    <div class="form-group">
                        <label for="workmanship">Изработка: </label>
                        <div class="input-group"> 
                            <input type="number" class="form-control worksmanship_price" name="workmanship" id="workmanship" value="0">
                            <span class="input-group-addon">лв</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price">Цена: </label>
                        <div class="input-group"> 
                            <input type="number" class="form-control final_price" name="price" id="price" value="0">
                            <span class="input-group-addon">лв</span>
                        </div>
                    </div>

                    <div class="drop-area" name="add">
                        <input type="file" name="images" class="drop-area-input" id="fileElem-add" multiple accept="image/*" >
                        <label class="button" for="fileElem-add">Select some files</label>
                        <div class="drop-area-gallery"></div>
                    </div>

                    <div id="errors-container"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" class="add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editProduct" role="dialog" aria-labelledby="editProductLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
        </div>
    </div>
</div>

<h3>Добави готово изделие <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#addProduct">Добави</button></h3>

<table class="table table-condensed">
    <tr>
        <th>Име</th> 
        <th>Виж бижу</th>
        <th>Цена на дребно</th>
        <th>Тегло</th>
        <th>Цена</th>
        <th>Баркод</th>
        <th>Уникален номер</th>
        <th>Действия</th>
    </tr>
    
    @foreach($products as $product)
        @include('admin.products.table')
    @endforeach
</table>

<form method="POST" action="">
    {{ csrf_field() }}

    {{--  <h3>Камъни към този модел</h3>

    <div class="model-stones">
        <div class="fields">
            <label>Камък: </label>
            <select name="stones[]" class="form-control">
                <option value="">Избери</option>
    
                @foreach($stones as $stone)
                    <option value="{{ $stone->id }}">{{ $stone->name }}</option>
                @endforeach
            </select>
    
            <div class="form-group">
                <label for="1">Брой: </label>
                <input type="text" class="form-control" id="1" name="stone_amount[]" placeholder="Брой:">
            </div>
            <br/>
        </div>
    </div>  --}}

    {{--  <button type="button" class="btn btn-primary add_field_button">Добави нов камък</button>  --}}
</form>

{{--  <h3>Видове модели</h3>

<table class="table table-condensed">
    <tr>
        <th>#</th>
        <th>Име</th> 
        <th>Виж бижу</th>
        <th>Цена на дребно</th>
        <th>Цена на едро</th>
        <th>Тегло</th>
        <th>Цена</th>
        <th>Действия</th>
    </tr>
    
    @foreach($models as $model)
        <tr>
            <td></td>
            <td> {{ $model->name }} </td>
            <td> {{ App\Jewels::find($model->jewel)->name }} </td> 
            <td> {{ App\Prices::find($model->retail_price)->price }} </td> 
            <td> {{ App\Prices::find($model->wholesale_price)->price }} </td>
            <td> {{ $model->weight }} </td>
            <td> {{ (App\Prices::find($model->retail_price)->price)*$model->weight }} </td>
            <td><a href="models/{{ $model->id }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
        </tr>

        <tr>
            <th>камъни</th>
            <td>
                <table class="table table-condensed">
                    <tr>
                        <th>тип</th>
                        <th>Брой</th>
                    </tr>

                    @foreach(App\Model_stones::where('model', $model->id)->get() as $stone)
                        <tr>
                            <td>{{ App\Stones::find($stone->stone)->name }}</td>
                            <td>{{ $stone->amount }}</td>
                        </tr>
                    @endforeach
                </table>
                
            </td>
        </tr>
    @endforeach
</table>  --}}
@endsection

@section('footer-scripts')
<script id="stones_data" type="application/json">
    {!!  $jsStones !!}
</script>
@endsection