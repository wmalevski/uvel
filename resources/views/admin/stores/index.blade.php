@extends('admin.layout')


@section('content')

<div class="modal fade" id="addStore" tabindex="-1" role="dialog" aria-labelledby="addStore"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStoreLabel">Добавяне на магазин</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">    
                    {{ csrf_field() }}                    
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Име на магазин:">
                    </div>
                
                    <div class="form-group">
                        <label for="1">Адрес: </label>
                        <input type="text" class="form-control" id="1" name="location" placeholder="Адрес на магазин:">
                    </div>
                
                    <div class="form-group">
                        <label for="1">Телефон: </label>
                        <input type="text" class="form-control" id="1" name="phone" placeholder="Телефон на магазин:">
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

<h3>Магазини <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStore">Добави</button></h3>

<table class="table table-condensed">
    <tr>
        <th>#</th>
        <th>Име</th>
        <th>Адрес</th> 
        <th>Телефон</th> 
        <th>Действия</th>
    </tr>
    
    @foreach($stores as $store)
        <tr>
            <td></td>
            <td>{{ $store->name }}</td> 
            <td>{{ $store->location }}</td> 
            <td>{{ $store->phone }}</td> 
            <td><a href="stores/{{ $store->id }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
        </tr>
    @endforeach
</table>
@endsection