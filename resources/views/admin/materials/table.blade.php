<tr>
    <td></td>
    <td>{{ $material->name }}</td> 
    <td>{{ $material->code }}</td> 
    <td>{{ $material->color }}</td> 
    <td><a href="materials/{{$material->id}}" class="edit-btn" data-toggle="modal" data-target="#editMaterial"><i class="c-brown-500 ti-pencil"></i></a></td>
</tr>