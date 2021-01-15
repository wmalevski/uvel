<div class="editModalWrapper">
	<div class="modal-header">
		<h5 class="modal-title" id="editContourLabel">Промяна на стойност</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>

	<form method="POST" name="system_setting" data-type="edit" action="/admin/system_settings/update/{{ $key }}">
		<input name="_method" type="hidden" value="PUT" />
		<input type="hidden" name="setting_var" value="{{ $key }}" />
		<div class="modal-body">
			<div class="info-cont">
				<div style="display:none;" class="alert alert-success">Промяната е успешно запазена!</div>
				<div style="display:none;" class="alert alert-danger">Възникна проблем при запазването на промяната!</div>
			</div>
			{{ csrf_field() }}
			<div class="form-group">
			@if ( $key == 'website_logo' )
				<div class="drop-area" name="add">
					<input type="file" name="website_logo" class="drop-area-input" id="website_logo" accept="image/*" />
					<label class="button" for="website_logo">Избери картинка за Лого</label>
					<div class="drop-area-gallery">
						<div class='image-wrapper'>
							<div class='close'><span data-url=""></span></div>
							<img src="" id="setting_preview" class="img-responsive" rel-name="" />
						</div>
					</div>
				</div>
			@elseif ( $key == 'website_header' )
				<div class="drop-area" name="add">
					<input type="file" name="website_header" class="drop-area-input" id="website_header" accept="image/*" />
					<label class="button" for="website_header">Избери картинка за Фон на хедъра</label>
					<div class="drop-area-gallery">
						<div class='image-wrapper'>
							<div class='close'><span data-url=""></span></div>
							<img src="" id="setting_preview" class="img-responsive" rel-name="" />
						</div>
					</div>
				</div>
			@else
				<label for="setting_value">{{ $friendly_name }}: </label>
				<input type="text" class="form-control" id="setting_value" value="{{ $value }}" name="setting_value" />
			@endif
			</div>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
			<button type="submit" id="add" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
		</div>
	</form>
</div>