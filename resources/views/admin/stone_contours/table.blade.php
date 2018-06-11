<tr data-id="{{ $contour->id }}">
    <td>{{ $contour->name }}</td> 
    <td>
        <span data-url="stones/contours/{{$contour->id}}" class="edit-btn" data-toggle="modal" data-target="#editContour"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="stones/contours/delete/{{$contour->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>