<tr data-id="{{ $substitution->id }}">
    <td>{{ App\User::withTrashed()->find($substitution->user_id)->name }}</td> 
    <td>{{ App\Stores::withTrashed()->find($substitution->store_id)->name }}</td> 
    <td>{{ Carbon\Carbon::parse($substitution->date_to)->format('d-m-Y') }}</td> 
    <td>{{ Carbon\Carbon::parse($substitution->date_to)->format('d-m-Y') }}</td>
    <td>
        <span data-url="users/substitutions/{{$substitution->id}}" class="edit-btn" data-toggle="modal" data-target="#editSubstitution"><i class="c-brown-500 ti-pencil"></i></span>
    </td> 
</tr>