<tr>
    <td>{{ $contour->name }}</td> 
    <td>
        <span data-url="stones/contours/{{$contour->id}}" class="edit-btn" data-toggle="modal" data-target="#editSize"><i class="c-brown-500 ti-pencil"></i></span>
        <a href="contours/delete/{{$contour->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></a>
    </td>
</tr>