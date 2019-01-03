<div class="editModalWrapper">
<div class="modal-header">
    <h5 class="modal-title" id="editSliderLabel">Редактиране на слайд</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form method="POST" id="edit-slides-form" action="slides/{{  }}" name="slides" data-type="edit" autocomplete="off">
    <div class="modal-body">
        <div class="info-cont">
        </div>
        {{ csrf_field() }}

        <div class="drop-area" name="add">
            <input type="file" name="images" class="drop-area-input" id="fileElem-edit" multiple accept="image/*" >
            <label class="button" for="fileElem-edit">Select some files</label>
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
            <input type="text" class="form-control" id="4" name="button_link" placeholder="Линк на бутона:">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
    </div>
</form>
</div>