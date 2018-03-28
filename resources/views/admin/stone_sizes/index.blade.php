@extends('admin.layout')

@section('content')
<div class="modal fade" id="addSize"   role="dialog" aria-labelledby="addSizeLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSizeLabel">Добавяне на размер</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="addSize" action="/stones/sizes">
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}                    
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Име на размер:">
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

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Камъни Размери <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSize">Добави</button></h4>
            <p>Преглед на създадените размери.</p>
            <table class="table table-condensed">
                <tr>
                    <th>#</th>
                    <th>Име</th> 
                </tr>
                
                @foreach($sizes as $size)
                    @include('admin.stone_sizes.table')
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection