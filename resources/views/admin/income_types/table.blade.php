<tr data-id="{{ $type->id }}">
	<td>{{ $type->name }}</td>
	<td>
		<span data-url="income_types/edit/{{$type->id}}" class="edit-btn" data-toggle="modal" data-target="#editIncomeType" data-form-type="edit" data-form="incomeTypes"><i class="c-brown-500 ti-pencil"></i></span>
		@if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
			<span data-url="income_types/delete/{{$type->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
		@endif
	</td>
</tr>