<div class="editModalWrapper">
	<div class="modal-header">
		<h5 class="modal-title" id="fullEditRepairLabel">Промени вид Приход</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>

	<form method="POST" data-type="edit" name="incomeTypes" action="income_types/{{ $type->id }}">
		<input name="_method" type="hidden" value="PUT" />
		<div class="modal-body">
			<div class="info-cont"></div>
			{{ csrf_field() }}

			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="name">Име: </label>
					<input type="text" class="form-control" id="name" value="{{ $type->name }}" name="name" placeholder="Име:">
				</div>
			</div>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
			<button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
		</div>
	</form>
</div>