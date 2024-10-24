<div class="editModalWrapper">
	<div class="modal-header">
		<h5 class="modal-title" id="addProductLabel">Редактиране на тип материал</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<form method="POST" name="materialsTypes" data-type="edit" action="materialstypes/{{ $material->id }}">
		<input name="_method" type="hidden" value="PUT">
		<div class="modal-body">
			<div class="info-cont"></div>
			{{ csrf_field() }}
			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="1">Име: </label>
					<input type="text" class="form-control" value="{{ $material->name }}" id="1" name="name" placeholder="Вид/Име:">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="site_navigation">Покажи в навигацията на сайта: <input type="checkbox" id="site_navigation" name="site_navigation" @if($material->site_navigation=='yes') checked @endif /></label>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
			<button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
		</div>
	</form>
</div>