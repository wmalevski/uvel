<tr data-id="{{ $stone->id }}">
    <td>{{ $stone->name }}</td> 
    <td> @if($stone->type == 1) Синтетичен  @else Естествен  @endif </td> 
    <td>{{ $stone->weight }}</td> 
    <td>{{ $stone->carat }}</td> 
    <td>{{ App\StoneSize::withTrashed()->find($stone->size)->name }}</td> 
    <td>{{ App\StoneStyle::withTrashed()->find($stone->style)->name }}</td> 
    <td>{{ App\StoneContour::withTrashed()->find($stone->contour)->name }}</td> 
    <td>{{ $stone->amount }}</td> 
    <td>{{ $stone->price }}</td>
    <td>
        <span data-url="stones/{{$stone->id}}" class="edit-btn" data-toggle="modal" data-target="#editStone"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="stones/delete/{{$stone->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> 
    </td>
</tr>