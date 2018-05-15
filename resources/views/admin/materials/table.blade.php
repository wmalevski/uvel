<tr data-id="{{ $material->id }}">
    <td>{{ App\Materials::find($material->id)->name }}</td> 
    <td>{{ $material->code }}</td> 
    <td>{{ $material->color }}</td> 
    <td>{{ $material->carat }}@if($material->carat)к@endif</td> 
    <td>{{ $material->stock_price }}</td> 
    <td>
        <span data-url="materials/{{$material->id}}" class="edit-btn" data-toggle="modal" data-target="#editMaterial"><i class="c-brown-500 ti-pencil"></i></span>
        <a href="materials/delete/{{$material->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></a> 
    </td>
</tr>