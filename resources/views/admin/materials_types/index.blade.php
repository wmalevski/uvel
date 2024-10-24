@extends('admin.layout')

@section('content')
<div class="modal fade" id="addMaterial"   role="dialog" aria-labelledby="addMateriallLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMaterialLabel">Добавяне на тип материал</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="materialsTypes" data-type="add" action="materialstypes" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <div id="success-container"></div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="1">Тип:</label>
                            <input type="text" class="form-control" id="1" name="name" placeholder="Тип/Име:">
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
        <h4 class="c-grey-900 mB-20">Тип Материал <button type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="materialTypes" data-toggle="modal" data-target="#addMaterial">Добави</button></h4>
        <p>Преглед на създадените типове материали.</p>
        <table id="main_table" class="table">
            <thead>
                <tr>
                    <th width="60%">Име</th>
                    <th width="30%">Покажи в навигация</th>
                    <th width="10%" data-sort-method="none">Действия</th>
                </tr>
            </thead>

            <tbody>
                @foreach($materials as $material)
                    @include('admin.materials_types.table')
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>
@endsection
