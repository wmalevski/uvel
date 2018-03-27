<tr>
    <td></td>
    <td>{{ $user->name }}</td> 
    <td>{{ $user->email }}</td> 
    <td>{{ $user->roles->first()['display_name'] }}</td>
    <td>@if($user->store != '') {{ App\Stores::find($user->store)->name }} @endif</td> 
    <td>
        <a href="users/{{$user->id}}" class="edit-btn" data-toggle="modal" data-target="#editUser"><i class="c-brown-500 ti-pencil"></i></a>
        <a href="#" data-toggle="modal" data-target="#userSubstitution"><i class="c-brown-500 ti-location-arrow"></i></a>
    </td>
</tr>