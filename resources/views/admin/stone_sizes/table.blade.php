<tr data-id="{{ $size->id }}">
    <td>{{ $size->name }}</td> 
    <td>
        <span data-url="stones/sizes/{{$size->id}}" class="edit-btn" data-toggle="modal" data-target="#editSize"><i class="c-brown-500 ti-pencil"></i></span>
        <a href="sizes/delete/{{$size->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></a>
    </td>
</tr>