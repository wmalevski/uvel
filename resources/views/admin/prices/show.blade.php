@extends('admin.layout')

@section('content')
<div class="modal fade" id="addPrice" tabindex="-1" role="dialog" aria-labelledby="addPriceLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPriceLabel">Добавяне на цена</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="addPrice" action="/prices/{{$material->id}}">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div id="success-container"></div>
                    
                        <div class="form-group">
                            <label for="1">Име: </label>
                            <input type="text" class="form-control" id="1" name="slug" placeholder="Етикет:">
                        </div>
                    
                        <div class="form-group">
                            <label for="2">Стойност: </label>
                            <input type="text" class="form-control" id="2" name="price" placeholder="Цена:">
                        </div>
                    
                        <label>Тип: </label>
                        <select name="type" class="form-control">
                            <option value="">Избери тип</option>
                    
                            <option value="buy">Купува</option>
                            <option value="sell">Продава</option>
                        </select>
                    
                        <input type="hidden" name="material" value="{{ $material->id }}">
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

<h3>Цени за {{ $material->name }} <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPrice">Добави</button></h3>

@if(isset($prices))
<h3>Купува</h3>

<table class="table table-condensed">
    <tr>
        <th>#</th>
        <th>Име</th> 
        <th>Стойност</th>
    </tr>
    
    @foreach($prices->where('type', 'buy') as $price)
        <tr>
            <td></td>
            <td>{{ $price->slug }}</td> 
            <td>{{ $price->price }}</td> 
        </tr>
    @endforeach
</table>

<h3>Продава</h3>

<table class="table table-condensed">
    <tr>
        <th>#</th>
        <th>Име</th> 
        <th>Стойност</th>
    </tr>
    
    @foreach($prices->where('type', 'sell') as $price)
        <tr>
            <td></td>
            <td>{{ $price->slug }}</td> 
            <td>{{ $price->price }}</td> 
        </tr>
    @endforeach
</table>


<h3>Добави цена</h3>

<form method="POST" class="form-inline" action="">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="1">Име: </label>
        <input type="text" class="form-control" id="1" name="slug" placeholder="Етикет:">
    </div>

    <div class="form-group">
        <label for="2">Стойност: </label>
        <input type="text" class="form-control" id="2" name="price" placeholder="Цена:">
    </div>

    <label>Тип: </label>
    <select name="type" class="form-control">
        <option value="">Избери тип</option>

        <option value="buy">Купува</option>
        <option value="sell">Продава</option>
    </select>

    <input type="hidden" name="material" value="{{ $material->id }}">

    <button type="submit" class="btn btn-default">Добави цена</button>
</form>
@endif
@endsection