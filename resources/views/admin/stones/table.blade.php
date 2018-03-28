<tr>
    <td scope="col"></td>
    <td>{{ $stone->name }}</td> 
    <td> @if($stone->type == 1) Синтатичен  @else Естествен  @endif </td> 
    <td>{{ $stone->weight }}</td> 
    <td>{{ $stone->carat }}</td> 
    <td>{{ App\Stone_sizes::find($stone->size)->name }}</td> 
    <td>{{ App\Stone_styles::find($stone->style)->name }}</td> 
    <td>{{ App\Stone_contours::find($stone->contour)->name }}</td> 
    <td>{{ $stone->amount }}</td> 
    <td>{{ $stone->price }}</td>
    <td><a href="#" data-path="stones/{{$stone->id}}" class="edit-btn" data-toggle="modal" data-target="#editStone"><i class="c-brown-500 ti-pencil"></i></a></td>
</tr>