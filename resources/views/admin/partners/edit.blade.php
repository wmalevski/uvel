<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="fullPartnerLabel">Редактиране на дължима сума</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="POST" action="partners/{{ $partner->id }}" name="partners" data-type="edit">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">    
            <div class="info-cont">
            </div>
    
            {{ csrf_field() }}  
                        
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="inputEmail4">Сума</label>
                    <input type="number" class="form-control" name="money" value="{{ $partner->money }}" placeholder="Баланс на партньора">
                </div>
                
            </div>
        </div>
    
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" class="edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
    </div>