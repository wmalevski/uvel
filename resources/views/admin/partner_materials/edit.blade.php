<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="fullPartnerMaterialLabel">Редактиране на материал</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="POST" action="partnermaterials/{{ $partner->id }}/{{ $material }}" name="partnermaterials" data-type="edit">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">
            <div class="info-cont">
            </div>

            {{ csrf_field() }}

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="inputEmail4">Наличност</label>
                    <input type="number" class="form-control" name="quantity" value="{{ $quantity }}" placeholder="Наличност">
                </div>

            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" class="edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
    </div>