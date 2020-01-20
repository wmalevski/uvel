<tr data-id="{{ $substitution->id }}">
    <td>{{ $substitution->user->email }}</td>
    <td>{{ $substitution->store->name }}</td> 
    <td>{{ Carbon\Carbon::parse($substitution->date_from)->format('d-m-Y') }}</td> 
    <td>{{ Carbon\Carbon::parse($substitution->date_to)->format('d-m-Y') }}</td>
    @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
        <td>
            <span data-url="users/substitutions/{{$substitution->id}}" class="edit-btn" data-form-type="edit" data-form="substitutions" data-toggle="modal" data-target="#editSubstitution"><i class="c-brown-500 ti-pencil"></i></span>
            <span data-url="users/substitutions/delete/{{$substitution->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
        </td>
    @endif
</tr>