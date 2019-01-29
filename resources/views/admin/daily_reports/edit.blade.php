<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="editDiscountLabel">Промяна на дневен отчет</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="POST" name="dailyReports" data-type="edit" action="dailyreports/{{ $report->id }}">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">
            <div class="info-cont">
                </div>
                {{ csrf_field() }}
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="1">Магазин: </label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="1" name="store_id" value="{{ $report->store->name }}" readonly>
                    </div>
                </div>
    
                <div class="form-group col-md-6">
                    <label for="inputZip">Поданен на</label>
                    <div class="input-group">
                        
                        <input type="text" name="date_expires" class="form-control" value="{{ $report->created_at }}" readonly>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="1">Сума от системата: </label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="1" name="calculated_price" value="{{ $report->calculated_price }}">
                    </div>
                </div>
    
                <div class="form-group col-md-6">
                    <label for="inputZip">Въведена от касата</label>
                    <div class="input-group">
                        
                        <input type="text" name="safe_amount" class="form-control" value="{{ $report->safe_amount }}">
                    </div>
                </div>
            </div>
    
            
            <div id="errors-container"></div>
        </div>
    
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" data-state="edit_state" class="action--state_button btn btn-primary">Промени</button>
        </div>
    </form>
    </div>
