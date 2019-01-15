<tr data-id="{{ $material->id }}">
    <td style="width: 32%;">{{ $material->name }}</td> 
    <td style="width: 12%;">
        <span data-url="materialstypes/{{$material->id}}" class="edit-btn" data-form-type="edit" data-form="materialTypes" data-toggle="modal" data-target="#editMaterial"><i class="c-brown-500 ti-pencil"></i></span>
        @if($material->id != 1)<span data-url="materialstypes/delete/{{$material->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> @endif
    </td>
</tr>