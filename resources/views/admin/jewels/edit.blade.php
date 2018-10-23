<div class="editModalWrapper">
<div class="modal-header">
    <h5 class="modal-title" id="fullEditRepairLabel">Промени бижу</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form method="POST" data-type="edit" name="jewels" action="jewels/{{ $jewel->id }}">
    <input name="_method" type="hidden" value="PUT">
    <div class="modal-body">    
            <div class="info-cont">
            </div>
        {{ csrf_field() }}

        <div class="form-group">
            <label for="1">Име: </label>
            <input type="text" class="form-control" value="{{ $jewel->name }}" id="1" name="name" placeholder="Име:">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
    </div>
</form>
</div>