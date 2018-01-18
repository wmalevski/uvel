@extends('admin.layout')

@section('content')
<div class="modal fade" id="addStyle" tabindex="-1" role="dialog" aria-labelledby="addStyleLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStyleLabel">Добавяне на стил</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="addStyle" action="/stones/styles">
                <div class="info-cont">
                </div> 
                <div class="modal-body">    
                    {{ csrf_field() }}                    
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Име на стил:">
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
<h3>Стилове Камъни <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="modal" data-target="#addStyle">Добави</button></h3>

<h3>Преглед на стилове</h3>

<table class="table table-condensed">
    <tr>
        <th>#</th>
        <th>Име</th> 
    </tr>
    
    @foreach($styles as $style)
        @include('admin.stone_styles.table')
    @endforeach
</table>
@endsection