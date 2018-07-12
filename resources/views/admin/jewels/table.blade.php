<tr data-id="{{ $jewel->id }}">
    <td>{{ $jewel->name }}</td> 
    <td>{{ App\Materials_type::withTrashed()->find(App\Material::withTrashed()->find($jewel->material)->parent)->name }} - {{ App\Material::withTrashed()->find($jewel->material)->color }} - {{ App\Material::withTrashed()->find(App\Material::withTrashed()->find($jewel->material)->parent)->code }}</td> 
    <td><span data-url="jewels/{{$jewel->id}}" class="edit-btn" data-toggle="modal" data-target="#editJewel"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="jewels/delete/{{$jewel->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>