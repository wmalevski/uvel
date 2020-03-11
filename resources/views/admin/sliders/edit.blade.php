<div class="editModalWrapper">
<div class="modal-header">
    <h5 class="modal-title" id="editSliderLabel">Редактиране на слайд</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form method="POST" id="edit-slides-form" action="slides/{{ $slider->id }}" name="slides" data-type="edit">
    <input name="_method" type="hidden" value="PUT">
    <div class="modal-body">
        <div class="info-cont">
        </div>
        {{ csrf_field() }}

        <div class="drop-area" name="add">
            <input type="file" name="images" class="drop-area-input" id="fileElem-edit" multiple accept="image/*" >
            <label class="button" for="fileElem-edit">Select some files</label>
            <div class="drop-area-gallery">
                <div class='image-wrapper'>
                    <div class='close'><span data-url="gallery/delete/{{$slider->id}}">&#215;</span></div>
                    <img src={{ asset("uploads/slides/". $slider->photo) }} alt="" class="img-responsive" />
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="1">Заглавие: </label>
            <input type="text" class="form-control" id="1" name="title" placeholder="Заглавие:" value="{{ $slider->title }}">
        </div>

        <div class="form-group">
            <label for="2">Кратко описание: </label>
            <input type="text" class="form-control" id="2" name="content" placeholder="Кратко описание:" value="{{ $slider->content }}">
        </div>

        <div class="form-group">
            <label for="3">Текст на бутона: </label>
            <input type="text" class="form-control" id="3" name="button_text" placeholder="Текст на бутона:" value="{{ $slider->button_text }}">
        </div>

        <div class="form-group">
            <label for="4">Линк на бутона: </label>
            <input type="text" class="form-control" id="4" name="button_link" value="{{ $slider->button_link }}">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
    </div>
</form>
</div>