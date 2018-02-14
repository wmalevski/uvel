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
            <form method="POST" action="/models" name="addModel">
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
                            <select id="jewel" name="jewel" class="form-control calculate">
                                <option value="">Избери</option>
                        
                                @foreach($jewels as $jewel)
                                    <option value="{{ $jewel->id }}" data-pricebuy="@if(App\Prices::where('material', $jewel->material)->where('type', 'buy')->first()){{App\Prices::where('material', $jewel->material)->where('type', 'buy')->first()->price}}@endif" data-price="{{$jewel->material}}">{{ $jewel->name }} - {{ App\Materials::find($jewel->material)->name }}, {{ App\Materials::find($jewel->material)->code }}, {{ App\Materials::find($jewel->material)->color }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Цена на дребно: </label>
                            <select id="retail_price" name="retail_price" class="form-control disabled-first calculate" disabled>
                                <option value="">Избери</option>
                        
                                @foreach($prices->where('type', 'sell') as $price)
                                    <option value="{{ $price->id }}" data-retail="{{ $price->price }}" data-material="{{ $price->material }}">{{ $price->slug }} - {{ $price->price }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Цена на едро: </label>
                            <select id="wholesale_price" name="wholesale_price" class="form-control disabled-first calculate" disabled>
                                <option value="">Избери</option>
                        
                                @foreach($prices->where('type', 'buy') as $price)
                                    <option value="{{ $price->id }}" data-pricebuy="{{ $price->price }}" data-material="{{ $price->material }}">{{ $price->slug }} - {{ $price->price }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="1">Тегло: </label>
                                <input type="text" class="form-control calculate" id="1" name="weight" placeholder="Тегло:">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="1">Размер: </label>
                                <input type="text" class="form-control" id="1" name="size" placeholder="Размер:">
                            </div>
                        </div>
                    </div>
                    <div class="model_stones">
                        <div class="form-row model-stones">        
                            <div class="form-group col-md-6">
                                <div class="form-group">
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
                            </div>
                            <div class="form-group col-md-6">
                                <div class="form-group">
                                    <label for="1">Брой: </label>
                                    <input type="text" class="form-control" id="1" name="stone_amount[]" placeholder="Брой:">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <button type="button" class="btn btn-primary add_field_button">Добави нов камък</button>
                    </div>

                    <br/>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label>Избработка:</label>
                                <input id="inputDev" type="text" class="form-control" value="0" name="workmanship">
                            </div>
                        </div>
                        
                         <div class="form-group col-md-6">
                            <div class="form-group">
                                <label>Цена:</label>
                                <input id="inputPrice" type="text" class="form-control" value="0" name="price">
                            </div>
                        </div>
                    </div>
                    <br/>

                    <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                        <input type="checkbox" id="inputCall1" name="release_product" class="peer">
                        <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                            <span class="peer peer-greed">Добави като продукт</span>
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" class="btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<h3>Видове модели <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModel">Добави</button></h3>

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
        @include('admin.models.table')
    @endforeach
</table>
@endsection

@section('footer-scripts')
<script id="stones_data" type="application/json">
    {
        "stones": {!! $jsStones !!}
    }

</script>
@endsection