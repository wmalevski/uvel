@extends('admin.layout')

@section('content')
<div class="modal fade" id="addStyle"   role="dialog" aria-labelledby="addStyleLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStyleLabel">Добавяне на стил</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="addStyle" action="stones/styles"> 
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}                    
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Име на стил:">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" data-state="add_state" class="action--state_button btn btn-primary add-btn-modal">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade edit--modal_holder" id="editStyle" tabindex="-1"  role="dialog" aria-labelledby="editStyle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Камъни Стилове <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStyle">Добави</button></h4>
            <p>Преглед на създадените стилове.</p>
            <table class="table table-condensed tablesort">
                <thead>
                    <tr>
                        <th>Име</th> 
                        <th class="sort-false">Действия</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($styles as $style)
                        @include('admin.stone_styles.table')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection