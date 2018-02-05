<tr>
    <td></td>
    <td>{{ $store->name }}</td> 
    <td>{{ $store->location }}</td> 
    <td>{{ $store->phone }}</td> 
    <td><a href="stores/{{$store->id}}" class="edit-btn" data-toggle="modal" data-target="#editStore"><i class="c-brown-500 ti-pencil"></i></a></td>
</tr>