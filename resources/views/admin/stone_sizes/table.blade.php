<tr data-id="{{ $size->id }}">
    <td>{{ $size->name }}</td> 
    <td>
        <span data-url="stones/sizes/{{$size->id}}" class="edit-btn" data-toggle="modal" data-form-type="edit" data-form="stoneSizes" data-target="#editSize"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="stones/sizes/delete/{{$size->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>