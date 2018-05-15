<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="editUserLabel">Заместване в друг обект</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    
    <form method="POST" name="sendUser" action="/users/substitutions/{{$user}}">
        <input name="_method" type="hidden" value="PUT">    
        <div class="modal-body">    
            <div class="info-cont">
            </div>
    
            {{ csrf_field() }}

            Служителя замества в {{ App\Stores::find($store)->name }}, от {{ $dateFrom }} до {{ $dateTo }}.
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        </div>
    </form>
</div>