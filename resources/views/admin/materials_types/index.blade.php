@extends('admin.layout')

@section('content')
<div class="modal fade" id="addMaterial"   role="dialog" aria-labelledby="addMateriallLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMaterialLabel">Добавяне на вид материал</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="addMaterial" action="materialstypes" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <div id="success-container"></div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="1">Име: </label>
                            <input type="text" class="form-control" id="1" name="name" placeholder="Вид/Име:">
                        </div>
                    </div>
                    <div id="errors-container"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editMaterial" role="dialog" aria-labelledby="editMaterialLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Тип Материал <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#addMaterial">Добави</button></h4>
        <p>Преглед на създадените типове материали.</p>
        <table class="table">
            <tr>
                <th style="width: 32%;">Име</th> 
                <th style="width: 12%">Действия</th> 
            </tr>
            
            @foreach($materials as $material)
                @include('admin.materials_types.table')
            @endforeach
        </table>
      </div>
    </div>
</div>
@endsection