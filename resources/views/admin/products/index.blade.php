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
            <form method="POST" action="/materials">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    
                    <div class="checkbox">
                        <label><input type="checkbox" name="with_stones" value="">Тегло без камъни</label>
                    </div>
                
                    <label>Модел: </label>
                    <select id="jewel" name="model" class="form-control">
                        <option value="">Избери</option>
                
                        @foreach($models as $model)
                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                        @endforeach
                    </select>
                
                    <label>Вид: </label>
                    <select id="jewel" name="jewel" class="form-control">
                        <option value="">Избери</option>
                
                        @foreach($jewels as $jewel)
                            <option value="{{ $jewel->id }}" data-price="{{ $jewel->material }}">{{ $jewel->name }}</option>
                        @endforeach
                    </select>
                
                    <label>Цена на едро: </label>
                    <select name="wholesale_price" class="form-control disabled-first" disabled>
                        <option value="">Избери</option>
                
                        @foreach($prices->where('type', 'sell') as $price)
                            <option value="{{ $price->id }}" data-material="{{ $price->material }}">{{ $price->slug }} - {{ $price->price }}</option>
                        @endforeach
                    </select>
                
                    <div class="form-group">
                        <label for="1">Тегло: </label>
                        <input type="text" class="form-control" id="1" name="weight" placeholder="Тегло:">
                    </div>
                
                    <div class="form-group">
                        <label for="1">Размер: </label>
                        <input type="text" class="form-control" id="1" name="size" placeholder="Размер:">
                    </div>
                
                    Изработка: 71<br/>
                    Цена: 256<br/><br/>
                    <div id="errors-container"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" class="btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<h3>Добави готово изделие <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProduct">Добави</button></h3>

<table class="table table-condensed">
    <tr>
        <th>Код</th>
        <th>Име</th> 
        <th>Виж бижу</th>
        <th>Цена на дребно</th>
        <th>Тегло</th>
        <th>Цена</th>
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