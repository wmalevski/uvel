@extends('admin.layout')

@section('content')


<div class="modal fade" id="addSlide"   role="dialog" aria-labelledby="addSlideLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStoneLabel">Добавяне на слайд</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="add-slides-form" action="slides" name="slides" data-type="add" autocomplete="off">
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}

                    <div class="drop-area" name="add">
                        <input type="file" name="images" class="drop-area-input" id="fileElem-add" accept="image/*" >
                        <label class="button" for="fileElem-add">Select some files</label>
                        <div class="drop-area-gallery"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="1">Заглавие: </label>
                        <input type="text" class="form-control" id="1" name="title" placeholder="Заглавие:">
                    </div>

                    <div class="form-group">
                        <label for="2">Кратко описание: </label>
                        <input type="text" class="form-control" id="2" name="content" placeholder="Кратко описание:">
                    </div>

                    <div class="form-group">
                        <label for="3">Текст на бутона: </label>
                        <input type="text" class="form-control" id="3" name="button_text" placeholder="Текст на бутона:">
                    </div>

                    <div class="form-group">
                        <label for="4">Линк на бутона: </label>
                        <input type="text" class="form-control" id="4" name="button_link" placeholder="Кратко описание:">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editSlide" role="dialog" aria-labelledby="editSlide"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Слайдове <button class="add-btn btn btn-primary" type="button" id="dropdownMenuButton" data-form-type="add" data-form="sliders" data-toggle="modal" data-target="#addSlide">Добави</button></h4>
      <p>Преглед на слайдове</p>
      <table class="table tablesort">
        <thead>
          <tr>
            <th scope="col">Заглавие</th> 
            <th scope="col">Кратко описание</th>
            <th scope="col">Бутон</th> 
            <th class="sort-false" scope="col">Действия</th>
          </tr>
        </thead>
        <tbody>
            @foreach($sliders as $slide)
                @include('admin.sliders.table')
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection