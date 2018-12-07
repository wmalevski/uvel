<tr data-id="{{ $phone->id }}">
    <td>{{ $phone->title }}</td> 
    <td>{{ $phone->phone }}</td> 
    <td><span data-url="infophones/{{$phone->id}}" class="edit-btn" data-toggle="modal" data-target="#editInfoPhone" data-form-type="edit" data-form="infophones"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="infophone/delete/{{$phone->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>