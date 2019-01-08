<tr data-id="{{ $partner->id }}">
    <td>{{ $partner->user->name }}</td> 
    <td>{{ $partner->money }}</td> 
    {{-- <td>{{ $user->email }}</td> 
    <td>{{ $user->roles->first()['title'] }}</td>
    <td>@if($user->store_id != '') {{ $user->store->name }} @endif</td> 
    --}}
    <td>
        <a href="partnermaterials/{{$partner->id}}"><i class="c-brown-500 ti-user"></i></a>
    </td>
</tr>