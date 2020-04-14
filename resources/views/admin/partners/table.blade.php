<tr data-id="{{ $partner->id }}">
    <td>{{ $partner->user->email }}</td>
    <td>{{ $partner->money }}</td> 
    <td>
        <a href="partnermaterials/{{$partner->id}}"><i class="c-brown-500 ti-user"></i></a>
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
            <span data-url="partners/{{$partner->id}}" class="edit-btn" data-toggle="modal" data-form-type="edit" data-form="partners" data-target="#editPartner"><i class="c-brown-500 ti-pencil"></i></span>
        @endif
    </td>
</tr>