<tr data-id="{{ $stone->id }}">
    <td class="thumbnail--tooltip">
        {{ $stone->name }}
        <ul>@if($stone->photos) {{ $stone->photos->first()['photo'] }} @endif</ul>
    </td> 
    <td> @if($stone->type == 1) Синтетичен  @else Естествен  @endif </td> 
    <td>{{ $stone->weight }}</td> 
    <td>{{ $stone->carat }}</td> 
    <td>{{ $stone->size->name }}</td>
    <td>{{ $stone->style->name }}</td>
    <td>{{ $stone->contour->name }}</td>
    <td>{{ $stone->amount }}</td> 
    <td>@if($stone->store) {{ $stone->store->name }} @endif</td>
    <td>{{ $stone->price }}</td>
    <td>
        <span data-url="stones/{{$stone->id}}" class="edit-btn" data-form-type="edit" data-form="stones" data-toggle="modal" data-target="#editStone"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="stones/delete/{{$stone->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> 

        @if($stone->amount == 0)
            <button type="button" class="btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Този камък няма наличност и няма да може да бъде използван за правене на продукти"><i class="c-red-500 ti-info-alt"></i></button>
        @endif
    </td>
</tr>