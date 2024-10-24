<tr data-id="{{ $user->id }}">
    <td>{{ $user->email }}</td>
    <td>{{ $user->roles->first()['title'] }}</td>
    <td>@if($user->store_id != '') {{ $user->store->name }} @endif</td> 
    <td>
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
            <span data-url="users/{{$user->id}}" class="edit-btn" data-form-type="edit" data-form="users"
                  data-toggle="modal" data-target="#editUser"><i class="c-brown-500 ti-pencil"></i></span>
            @if($user->id != 1)<span data-url="users/delete/{{$user->id}}" class="delete-btn"><i
                        class="c-brown-500 ti-trash"></i></span>@endif
        @endif
    </td>
</tr>