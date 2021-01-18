<tr data-id="{{ $inc->id }}">
	<td>{{ $inc->type->name }}</td>
	<td>{{ $inc->amount }}</td>
	<td>{{ $inc->store_id }}</td>
	<td>{{ $inc->currency->name }}</td>
	<td>{{ $inc->additional_info }}</td>
	@if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
		<td><span data-url="income/{{$inc->id}}" class="edit-btn" data-toggle="modal" data-target="#editIncome" data-form-type="edit" data-form="income"><i class="c-brown-500 ti-pencil"></i></span>
			<span data-url="income/delete/{{$inc->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
		</td>
	@endif
</tr>