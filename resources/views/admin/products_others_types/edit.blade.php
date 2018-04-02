<div class="modal-header">
    <h5 class="modal-title" id="editProductTypeLabel">Промяна на вид на продукт</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form method="POST" name="edit" action="/productsotherstypes/{{ $type->id }}">
    <input name="_method" type="hidden" value="PUT">
    <div class="modal-body">    
        <div class="info-cont">
        </div>

        {{ csrf_field() }}

        <div class="form-group">
            <label for="1">Име: </label>
            <input type="text" class="form-control" value="{{ $type->name }}" id="1" name="name" placeholder="Име на тип продукт:">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="add" class="btn btn-primary" data-dismiss="modal">Промени</button>
    </div>
</form>