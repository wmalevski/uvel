<tr data-id="{{ $material->id }}">
    <td style="width: 16%;">@if($material->parent){{ App\MaterialType::withTrashed()->find($material->parent)->name }}@endif</td> 
    <td style="width: 14%;">{{ $material->code }}</td> 
    <td style="width: 14%;">{{ $material->color }}</td> 
    <td style="width: 14%;">{{ $material->carat }}@if($material->carat)к@endif</td> 
    <td style="width: 14%;">{{ $material->stock_price }}</td> 
    <td style="width: 12%;">
        <span data-url="materials/{{$material->id}}" class="edit-btn" data-toggle="modal" data-target="#editMaterial"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="materials/delete/{{$material->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> 
    </td>
</tr>