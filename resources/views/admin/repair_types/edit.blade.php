<div class="editModalWrapper">
<div class="modal-header">
    <h5 class="modal-title" id="editRepairTypeLabel">Промяна на тип ремонтна дейност</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form method="POST" name="edit" action="/repairtypes/{{ $repair->id }}">
    <input name="_method" type="hidden" value="PUT">
    <div class="modal-body">    
        <div class="info-cont">
        </div>

        {{ csrf_field() }}

        <div class="form-group">
            <label for="1">Име: </label>
            <input type="text" class="form-control" value="{{ $repair->name }}" id="1" name="name" placeholder="Име на ремонтна дейност:">
        </div>

        <div class="form-group">
            <label for="1">Цена: </label>
            <input type="number" class="form-control"value="{{ $repair->price }}" name="price" placeholder="Цена на ремонтната дейност:" min="0">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="add" class="btn btn-primary" data-dismiss="modal">Промени</button>
    </div>
</form>
</div>