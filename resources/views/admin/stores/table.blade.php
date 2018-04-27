<tr>
    <td>{{ $store->name }}</td> 
    <td>{{ $store->location }}</td> 
    <td>{{ $store->phone }}</td> 
    <td>
        <span data-url="stores/{{$store->id}}" class="edit-btn" data-toggle="modal" data-target="#editStore"><i class="c-brown-500 ti-pencil"></i></span>
        <a href="stores/delete/{{$store->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></a>
    </td>
</tr>
<!--data-toggle="modal" data-target="#editStore" -->