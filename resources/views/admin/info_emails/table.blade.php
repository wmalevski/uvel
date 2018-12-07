<tr data-id="{{ $email->id }}">
    <td>{{ $email->title }}</td> 
    <td>{{ $email->email }}</td> 
    <td><span data-url="infoemails/{{$email->id}}" class="edit-btn" data-toggle="modal" data-target="#editInfoEmail" data-form-type="edit" data-form="infoemails"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="infoemails/delete/{{$email->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>