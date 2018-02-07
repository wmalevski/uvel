<tr>
    <td></td>
    <td>{{ App\Materials::find($material->material)->name }}</td> 
    <td>{{ $material->quantity }}</td> 
    <td>{{ $material->carat }}</td> 
    <td><a href="materials/{{$material->id}}" class="edit-btn" data-toggle="modal" data-target="#editMaterial"><i class="c-brown-500 ti-pencil"></i></a></td>
</tr>