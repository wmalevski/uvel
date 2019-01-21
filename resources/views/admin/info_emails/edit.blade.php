<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="fullEditRepairLabel">Промени имейл</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <form method="POST" data-type="edit" name="infoemails" action="infoemails/{{ $email->id }}">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">    
                <div class="info-cont">
                </div>
            {{ csrf_field() }}
    
            <div class="form-group">
                <label for="1">Заглавие: </label>
                <input type="text" class="form-control" value="{{ $email->title }}" id="1" name="name" placeholder="Заглавие:">
            </div>

            <div class="form-group">
                <label for="1">Имейл: </label>
                <input type="email" class="form-control" value="{{ $email->email }}" id="1" name="name" placeholder="Имейл:">
            </div>
        </div>
    
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
    </div>