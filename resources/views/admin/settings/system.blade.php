@extends('admin.layout')

@section('content')
@if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'storehouse']))
<div class="modal fade edit--modal_holder" id="editVar" role="dialog" aria-labelledby="editVarLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editVarLabel">Промяна на настройка</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<form method="POST" name="system_setting" data-type="edit" action="/admin/system_settings/update/">
				<input name="_method" type="hidden" value="PUT" />

				<div class="modal-body">
					<div class="info-cont"></div>
					{{ csrf_field() }}
					<div class="drop-area" name="add">
						<input type="file" name="website_logo" class="drop-area-input" id="website_logo" accept="image/*" />
						<label class="button" for="website_logo">Избери картинка за Лого</label>
						<div class="drop-area-gallery"></div>
					</div>
					<div class="form-group">
						<label for="setting_value">: </label>
						<input type="text" class="form-control" id="setting_value" value="" name="setting_value" />
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
					<button type="submit" id="add" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
				</div>
			</form>

		</div>
	</div>
</div>

<h3>Системни Настройки</h3>

<table id="main_table" class="table table-condensed models-table tablesort table-fixed">
	<thead>
		<tr data-sort-method="thead">
			<th>Име</th>
			<th>Стойност</th>
			<th data-sort-method="none">Действия</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($settings as $setting)
			<tr rel="{{ $setting->key }}">
				<td>{{ $setting->friendly_name }}</td>
				<td>
					@if ( $setting->key == 'website_logo' || $setting->key == 'website_header' )
						<img border=0 src="{{ $setting->value }}" style="max-height: 40px"/>
					@else
						{{ $setting->value }}
					@endif
				</td>
				<td>
					<span data-url="system_settings/edit/{{ $setting->key }}" class="edit-btn" data-form-type="edit" data-form="models" data-toggle="modal" data-target="#editVar"><i class="c-brown-500 ti-pencil"></i></span>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
@endif
@endsection

@section('footer-scripts')
<script>
	$(document).ready(function(){
		// Image Preview
		$(document).on('change','input[type="file"]',function(){
			var reader = new FileReader();
			reader.onload = function(e){
				$('img#setting_preview').attr('src',e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
			$('img#setting_preview').attr('rel-name','/uploads/'+this.files[0].name);
		});

		// Form Submit
		$(document).on('submit','form',function(e){
			e.preventDefault();

			var setting_key = $('input[name="setting_var"]').val();

			$.ajax({
				method: 'POST',
				url: $('form[name="system_setting"]').attr('action'),
				processData: false,
				contentType: false,
				data: new FormData(this),

				success:function(response){
					$('div.alert-success').show();
					if(setting_key == 'website_header' || setting_key == 'website_logo'){
						$('tr[rel="'+setting_key+'"] td:nth-child(2)').html('<img border="0" src="'+
							$('img#setting_preview').attr('rel-name')+
							'" style="max-height: 40px">');
						if(setting_key == 'website_logo'){
							$('div.sidebar div.sidebar-logo div.logo').html('<img border="0" src="'+
								$('img#setting_preview').attr('rel-name')+
							'" style="height: 64px">');
						}
					}
					else{
						$('tr[rel="'+setting_key+'"] td:nth-child(2)').html($('input[name="setting_value"]').val());
					}
					setTimeout(function(){
						$('div.modal').hide().removeClass('in show');
						$('body').removeClass('modal-open');
						$('div.modal-backdrop').remove();
					}, 1000);
				},
				error:function(response){
					$('div.alert-danger').show();
					console.log(response);
				}
			});

		});
	});
</script>
@endsection