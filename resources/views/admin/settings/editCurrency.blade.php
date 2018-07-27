<div class="editModalWrapper">
    
        <div class="modal-header">
            <h5 class="modal-title" id="editContourLabel">Промяна на валута</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    
        <form method="POST" name="edit" action="/settings/currencies/{{ $currency->id }}">
            <input name="_method" type="hidden" value="PUT">
            <div class="modal-body">    
                <div class="info-cont">
                </div>
                {{ csrf_field() }}  
                            
                <div class="form-group">
                    <label for="1">Валута: </label>
                    <input type="text" class="form-control" id="1" value="{{ $currency->name }}" name="name" placeholder="Валута:">
                </div>
            
                <div class="form-group">
                    <label for="2">Курс: </label>
                    <input type="number" class="form-control" id="2" value="{{ $currency->currency }}" name="currency" placeholder="Курс на валута:" min="0.1">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                <button type="submit" id="add" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
            </div>
        </form>
    
    
    </div>
    