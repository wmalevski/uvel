<div class="editModalWrapper">

    <div class="modal-header">
        <h5 class="modal-title" id="editStoreLabel">Промяна на магазин</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <form method="POST" name="edit" action="/stores/{{ $store->id }}">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">    
            <div class="info-cont">
            </div>

            {{ csrf_field() }}

            <div class="form-group">
                <label for="1">Име:</label>
                <input type="text" class="form-control" value="{{ $store->name }}" id="1"  name="name" placeholder="Име на магазин:" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="1">Адрес: </label>
                <input type="text" class="form-control" value="{{ $store->location }}" id="1" name="location" placeholder="Адрес на магазин:" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="1">Телефон: </label>
                <input type="text" class="form-control" value="{{ $store->phone }}" id="1" name="phone" placeholder="Телефон на магазин:" autocomplete="off">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>


</div>
