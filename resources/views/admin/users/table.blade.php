<tr>
    <td></td>
    <td>{{ $user->name }}</td> 
    <td>{{ $user->email }}</td> 
    <td>{{ $user->roles->first()['title'] }}</td>
    <td>@if($user->store != '') {{ App\Stores::find($user->store)->name }} @endif</td> 
    <td>
        <span data-url="users/{{$user->id}}" class="edit-btn" data-toggle="modal" data-target="#editUser"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="users/substitution/{{$user->id}}" class="edit-btn" data-toggle="modal" data-target="#userSubstitution"><i class="c-brown-500 ti-location-arrow"></i></a>
    </td>
</tr>