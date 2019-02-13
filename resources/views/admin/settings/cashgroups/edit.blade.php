<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="fullEditRepairLabel">Редактиране на касова група</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="POST" action="settings/cashgroups/{{ $cashgroup->id }}" name="cashgroup" data-type="edit">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">    
            <div class="info-cont">
            </div>

            {{ csrf_field() }}  

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="3">Касова група : </label>
                    <input type="number" class="form-control" value="{{ $cashgroup->cash_group }}" name="cash_group" placeholder="Касова група:">
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
</div>