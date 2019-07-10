@extends('admin.layout')

@section('content')
<div class="modal fade" id="addContour"   role="dialog" aria-labelledby="addContourLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContourLabel">Добавяне на контур</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="stoneContours" data-type="add" action="stones/contours">
                <div class="modal-body">  
                    <div class="info-cont">
                    </div>  
                    {{ csrf_field() }}                    
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Име на контур:">
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

<div class="modal fade" id="editContour" tabindex="-1"  role="dialog" aria-labelledby="editContour">
    <div class="modal-dialog edit--modal_holder" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Камъни контури <button type="button" class="btn btn-primary" data-form-type="add" data-form="stoneContours" data-toggle="modal" data-target="#addContour">Добави</button></h4>
        <p>Преглед на създадените контури.</p>
        <table id="main_table" class="table table-condensed tablesort">
            <thead>
                <tr>
                    <th>Име</th> 
                    <th data-sort-method="none">Действия</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($contours as $contour)
                    @include('admin.stone_contours.table')
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>
@endsection
