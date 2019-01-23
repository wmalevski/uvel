<tr data-id="{{ $type->id }}">
    <td>{{ $type->name }}</td> 
    <td><span data-url="expensetypes/{{$type->id}}" class="edit-btn" data-toggle="modal" data-target="#editExprenseType" data-form-type="edit" data-form="expenses"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="expensetypes/delete/{{$type->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>