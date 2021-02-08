<div class="editModalWrapper">
	<div class="modal-header">
		<h5 class="modal-title" id="modalCMSBlockLabel">{{ $friendly_name }}</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>

	<form method="POST" data-type="edit" name="CMS" action="{{ route('cms_update', $key) }}">
		<input name="_method" type="hidden" value="PUT" />
		<input name="cms_key" type="hidden" value="{{ $key }}" />
		<div class="modal-body">
			<div class="info-cont">
				<div style="display:none;" class="alert alert-success">Промяната е успешно запазена!</div>
				<div style="display:none;" class="alert alert-danger">Възникна проблем при запазването на промяната!</div>
			</div>
			{{ csrf_field() }}

			<!-- DYNAMIC -->
			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="block_value">Съдържание: </label>
					<textarea class="summernote" name="block_value">{!! $value !!}</textarea>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
			<button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
		</div>
	</form>
</div>