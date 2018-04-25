<tr>
    <td>{{ $store->name }}</td> 
    <td>{{ $store->location }}</td> 
    <td>{{ $store->phone }}</td> 
    <td>
        <span data-url="stores/{{$store->id}}" class="edit-btn" data-toggle="modal" data-target="#editStore"><i class="c-brown-500 ti-pencil"></i></span>
    </td>
</tr>
<!--data-toggle="modal" data-target="#editStore" -->