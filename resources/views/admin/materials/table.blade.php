<tr>
    <td></td>
    <td>{{ App\Materials::find($material->id)->name }}</td> 
    <td>{{ $material->code }}</td> 
    <td>{{ $material->color }}</td> 
    <td><a href="mquantity/{{$material->id}}" class="edit-btn" data-toggle="modal" data-target="#editMQuantity"><i class="c-brown-500 ti-pencil"></i></a></td>
</tr>