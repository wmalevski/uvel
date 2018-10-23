<tr data-id="{{ $jewel->id }}">
    <td>{{ $jewel->name }}</td> 
    <td><span data-url="jewels/{{$jewel->id}}" class="edit-btn" data-toggle="modal" data-target="#editJewel" data-form-type="edit" data-form="jewels"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="jewels/delete/{{$jewel->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>