<tr data-id="{{ $material->id }}">
    <td>{{ $material->material->parent->name }} - {{ $material->material->code }} - {{ $material->material->color }}</td> 
    <td>{{ $material->quantity }}</td> 
    <td>{{ $material->store->name }}</td>
    <td>
        <span data-url="mquantity/{{$material->id}}" class="edit-btn" data-toggle="modal" data-target="#editMQuantity"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="mquantity/delete/{{$material->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> 
    </td>
</tr>