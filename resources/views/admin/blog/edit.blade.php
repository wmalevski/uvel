<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="fullEditRepairLabel">Промени статия</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <form method="POST" data-type="edit" name="blog" action="blog/{{ $article->id }}">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">    
                <div class="info-cont">
                </div>
            {{ csrf_field() }}
    
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="1">Заглавие: </label>
                    <input type="text" class="form-control" id="1" name="title" value="{{ $article->title }}" placeholder="Заглавие:">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="1">Описание: </label>
                    <textarea class="form-control" name="excerpt" rows="1">{{ $article->excerpt }}</textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="1">Съдържание: </label>
                    <textarea id="summernote" name="content">{!! $article->content !!}</textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="1">Снимка: </label>
                    <div class="drop-area" name="add">
                        <input type="file" name="images" class="drop-area-input" id="fileElem-add" accept="image/*" >
                        <label class="button" for="fileElem-add">Select some files</label>
                        <div class="drop-area-gallery"></div>
                    </div>
                </div>
            </div>
            <div class="uploaded-images-area">
                <div class='image-wrapper'>
                    <img src="{{ asset("uploads/blog/" . $article->thumbnail) }}" alt="" class="img-responsive" />
                </div>
            </div>
        </div>
    
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
    </div>