@extends('admin.layout')

@section('content')
@if(in_array(\Illuminate\Support\Facades\Auth::user()->role, array('admin')))
<div class="modal fade edit--modal_holder" id="editBlock" role="dialog" aria-labelledby="modalCMSBlockLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalCMSBlockLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<form method="POST" name="cms_model" data-type="edit" action="cms" autocomplete="off">
				<div class="modal-body">
					<div class="info-cont"></div>
					{{ csrf_field() }}

					<!-- TEMPLATE -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane">
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="block_value">Съдържание: </label>
									<textarea class="summernote" name="block_value"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
					<button type="submit" id="add" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
				</div>
			</form>
		</div>
	</div>
</div>

<h3>Информационни Блокове</h3>

<table id="main_table" class="table table-condensed models-table tablesort table-fixed">
	<thead>
		<tr data-sort-method="thead">
			<th width="60%">Име</th>
			<th width="20%">Съдържание</th>
			<th width="20%" data-sort-method="none">Действия</th>
		</tr>
	</thead>
	<tbody>
	@foreach($info_blocks as $block)
		<tr rel="{{ $block->key }}">
			<td>{{ $block->friendly_name }}</td>
			<td>@if(strlen($block->value)>0) <i>HTML</i> @else @endif</td>
			<td>
				<span data-url="cms/edit/{{ $block->key }}" class="edit-btn" data-form-type="edit" data-form="cms" data-toggle="modal" data-target="#editBlock"><i class="c-brown-500 ti-pencil"></i></span>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
@endif
@endsection

@section('footer-scripts')
<style type="text/css">
	.modal-dialog{max-width: 80%;}
	.note-toolbar-wrapper.panel-default{min-height:38px;}
	div.note-insert button[data-original-title="Picture"], div.note-insert button[data-original-title="Video"]{display:none;}
	div.dropdown-menu.dropdown-style{min-width:200px;}
</style>
<script>
	$(document).ready(function(){




$('.summernote').summernote({
	height: 300,
	popover: {
		image: [],
		link: [],
		air: []
	}
});



		// Form Submit
		$(document).on('submit','form',function(e){
			e.preventDefault();

			var cms_key = $('input[name="cms_key"]').val();
			$('textarea[name="block_value"]').html($('.summernote').summernote('code'));

			$.ajax({
				method: 'POST',
				url: $('form[name="CMS"]').attr('action'),
				processData: false,
				contentType: false,
				data: new FormData(this),

				success:function(response){
					$('div.alert-success').show();
					$('tr[rel="'+cms_key+'"] td:nth-child(2)').html('<i>HTML</i>');
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