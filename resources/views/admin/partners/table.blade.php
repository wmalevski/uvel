<tr data-id="{{ $partner->id }}">
    <td>{{ $partner->user->name }}</td> 
    <td>{{ $partner->money }}</td> 
    {{-- <td>{{ $user->email }}</td> 
    <td>{{ $user->roles->first()['title'] }}</td>
    <td>@if($user->store_id != '') {{ $user->store->name }} @endif</td> 
    --}}
    <td>
        <a href="partnermaterials/{{$partner->id}}"><i class="c-brown-500 ti-user"></i></a>
        <span data-url="partners/{{$partner->id}}" class="edit-btn" data-toggle="modal" data-form-type="edit" data-form="partners" data-target="#editPartner"><i class="c-brown-500 ti-pencil"></i></span>
    </td>
</tr>