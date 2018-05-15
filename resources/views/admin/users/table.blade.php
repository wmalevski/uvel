<tr data-id="{{ $user->id }}">
    <td>{{ $user->name }}</td> 
    <td>{{ $user->email }}</td> 
    <td>{{ $user->roles->first()['title'] }}</td>
    <td>@if($user->store != '') {{ App\Stores::find($user->store)->name }} @endif</td> 
    <td>
        <span data-url="users/{{$user->id}}" class="edit-btn" data-toggle="modal" data-target="#editUser"><i class="c-brown-500 ti-pencil"></i></span>
        @if($user->id != 1)<a href="users/delete/{{$user->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></a>@endif
    </td>
</tr>