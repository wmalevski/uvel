@extends('admin.layout')

@section('content')
<div class="modal fade" id="addContour" tabindex="-1" role="dialog" aria-labelledby="addContourLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContourLabel">Добавяне на контур</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="addContour" action="/stones/contours">
                <div class="info-cont">
                </div>
                <div class="modal-body">    
                    {{ csrf_field() }}                    
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Име на контур:">
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
<h3>Контури Камъни <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="modal" data-target="#addContour">Добави</button></h3>

<h3>Преглед на контури</h3>

<table class="table table-condensed">
    <tr>
        <th>#</th>
        <th>Име</th> 
    </tr>
    
    @foreach($contours as $contour)
        @include('admin.stone_contours.table')
    @endforeach
</table>
@endsection