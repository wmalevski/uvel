<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="fullExpenseLabel">Промени по разход</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <form method="POST" data-type="edit" name="expense" action="expenses/{{ $expense->id }}">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">    
                <div class="info-cont">
                </div>
            {{ csrf_field() }}
    
            <div class="form-group">
                <label for="1">Име: </label>
                <input type="text" class="form-control" value="{{ $expense->name }}" id="1" name="name" placeholder="Име:">
            </div>

            <div class="form-group">
                <label for="1">Сума: </label>
                <input type="text" class="form-control" value="{{ $expense->amount }}" id="1" name="amount" placeholder="Име:">
            </div>

            <div class="form-group">
                <label for="1">Валута: </label>
                <input type="text" class="form-control" value="{{ $expense->curreny_id }}" id="1" name="curreny_id" placeholder="Име:">
            </div>

            <div class="form-group">
                <label for="1">Пояснение: </label>
                <textarea class="form-control">
                    {{ $expense->additional_info }}
                </textarea>
            </div>
        </div>
    
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
</div>