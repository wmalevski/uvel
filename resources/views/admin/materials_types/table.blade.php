<tr data-id="{{ $material->id }}">
	<td>{{ $material->name }}</td>
	<td>{{ ($material->site_navigation=='yes'?'Да':'Не') }}</td>
	<td><span data-url="materialstypes/{{$material->id}}" class="edit-btn" data-form-type="edit" data-form="materialTypes" data-toggle="modal" data-target="#editMaterial"><i class="c-brown-500 ti-pencil"></i></span>
		@if($material->id != 1 && Auth::user()->role == 'admin')<span data-url="materialstypes/delete/{{$material->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>@endif
	</td>
</tr>