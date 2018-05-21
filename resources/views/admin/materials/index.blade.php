@extends('admin.layout')

@section('content')
<div class="modal fade" id="addMaterial"   role="dialog" aria-labelledby="addMateriallLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMaterialLabel">Добавяне на материал</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="addMaterial" action="/materials" autocomplete="off">
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
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="2">Проба: </label>
                            <input type="number" class="form-control" id="2" name="code" placeholder="Проба:">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="3">Цвят: </label>
                            <input type="text" class="form-control" id="3" name="color" placeholder="Цвят:">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="3">Карат: </label>
                            <input type="number" class="form-control" id="4" name="carat" placeholder="Карати:">
                        </div>
                    </div>
                    <div id="errors-container"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" class="add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editMaterial" role="dialog" aria-labelledby="editMaterialLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMaterialLabel">Редактиране на модел</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="addModel" action="/materials">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="edit" class="btn btn-primary">Промени</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Материали <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#addMaterial">Добави</button></h4>
        <p>Преглед на създадените материали.</p>
        <table class="table">
            <tr>
                <th width="32%">Име</th> 
                <th width="14%">Проба</th> 
                <th width="14%">Цвят</th> 
                <th width="14%">Карат</th>
                <th width="14%">Борсова Цена</th>
                <th width="12%">Действия</th> 
            </tr>
            
            @foreach($materials as $material)
                @include('admin.materials.table')
            @endforeach
        </table>
      </div>
    </div>
</div>
@endsection