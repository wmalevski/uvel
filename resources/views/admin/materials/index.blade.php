@extends('admin.layout')


@section('content')
<div class="modal fade" id="addMaterial" tabindex="-1" role="dialog" aria-labelledby="addMateriallLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMaterialLabel">Добавяне на материал</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group">
                            <label for="1">Име: </label>
                            <input type="text" class="form-control" id="1" name="name" placeholder="Вид/Име:">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="2">Проба: </label>
                            <input type="text" class="form-control" id="2" name="code" placeholder="Проба:">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="3">Цвят: </label>
                            <input type="text" class="form-control" id="3" name="color" placeholder="Цвят:">
                        </div>
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

<h3>Преглед на материали <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMaterial">Добави</button></h3>

<table class="table table-condensed">
    <tr>
        <th>#</th>
        <th>Име</th> 
        <th>Проба</th> 
        <th>Цвят</th> 
        <th>Действия</th> 
    </tr>
    
    @foreach($materials as $material)
        <tr>
            <td></td>
            <td>{{ $material->name }}</td> 
            <td>{{ $material->code }}</td> 
            <td>{{ $material->color }}</td> 
            <td><a href="materials/{{ $material->id }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
        </tr>
    @endforeach
</table>
@endsection