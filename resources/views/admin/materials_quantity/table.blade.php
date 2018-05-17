<tr data-id="{{ $material->id }}">
    <td>{{ App\Materials::withTrashed()->find($material->material)->name }} - {{ App\Materials::withTrashed()->find($material->material)->code }} - {{ App\Materials::withTrashed()->find($material->material)->color }}</td> 
    <td>{{ $material->quantity }}</td> 
    <td>{{ App\Stores::withTrashed()->find($material->store)->name }}</td>
    <td>
        {{-- <a href="materials/{{$material->id}}" class="edit-btn" data-toggle="modal" data-target="#editMaterial"><i class="c-brown-500 ti-pencil"></i></a> --}}
        <span data-url="mquantity/{{$material->id}}" class="edit-btn" data-toggle="modal" data-target="#editMQuantity"><i class="c-brown-500 ti-pencil"></i></span>
        
        <a href="mquantity/delete/{{$material->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></a> 
    </td>
</tr>