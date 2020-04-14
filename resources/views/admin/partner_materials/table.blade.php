<tr data-id="{{ $material->id }}">
    <td>{{ $material->material->material->name }} - {{ $material->material->material->color }} - {{ $material->material->material->code }}</td> 
    <td>{{ $material->quantity }}</td> 
    @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
        <td>
            <span data-url="partnermaterials/{{$partner->id}}/{{$material->id}}" class="edit-btn" data-toggle="modal" data-form-type="edit" data-form="partnermaterials" data-target="#editPartnerMaterial"><i class="c-brown-500 ti-pencil"></i></span>
        </td>
    @endif
</tr>
