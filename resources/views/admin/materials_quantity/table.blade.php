<tr>
    <td>{{ App\Materials::find($material->material)->name }} - {{ App\Materials::find($material->material)->code }} - {{ App\Materials::find($material->material)->color }}</td> 
    <td>{{ $material->quantity }}</td> 
    <td>{{ App\Stores::find($material->store)->name }}</td>
    <td>
        {{-- <a href="materials/{{$material->id}}" class="edit-btn" data-toggle="modal" data-target="#editMaterial"><i class="c-brown-500 ti-pencil"></i></a> --}}
        <span data-url="mquantity/{{$material->id}}" class="edit-btn" data-toggle="modal" data-target="#editMQuantity"><i class="c-brown-500 ti-pencil"></i></span>
    </td>
</tr>