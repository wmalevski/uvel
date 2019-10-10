<tr data-id="{{ $store->id }}">
    <td>{{ $store->id }}</td>
    <td>{{ $store->name }}</td> 
    <td>{{ $store->location }}</td> 
    <td>{{ $store->phone }}</td> 
    <td>
        <span data-url="stores/{{$store->id}}" class="edit-btn" data-form-type="edit" data-form="stores" data-toggle="modal" data-target="#editStore"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="stores/delete/{{$store->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
        <a href="stores/info/{{ $store->id }}"><i class="c-brown-500 ti-user"></i></a>
    </td>
</tr>