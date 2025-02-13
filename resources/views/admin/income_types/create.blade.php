<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Добавяне на вид Приход</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<form method="POST" name="incomeTypes" data-type="add" action="income_types" autocomplete="off">
    <div class="modal-body">
        <div class="info-cont"></div>
        {{ csrf_field() }}
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="name">Име: </label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Име на вида Приход">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
    </div>
</form>