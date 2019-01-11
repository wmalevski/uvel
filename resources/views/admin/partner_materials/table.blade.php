<tr data-id="{{ $material->id }}">
    <td>{{ $material->material->material->name }} - {{ $material->material->material->color }} - {{ $material->material->material->carat }}к</td> 
    <td>{{ $material->quantity }}</td> 
    {{-- <td>{{ $user->email }}</td> 
    <td>{{ $user->roles->first()['title'] }}</td>
    <td>@if($user->store_id != '') {{ $user->store->name }} @endif</td> 
    --}}
    <td>
        <span data-url="partnermaterials/{{$partner->id}}/{{$material->id}}" class="edit-btn" data-toggle="modal" data-form-type="edit" data-form="partnermaterials" data-target="#editPartnerMaterial"><i class="c-brown-500 ti-pencil"></i></span>
    </td>
</tr>