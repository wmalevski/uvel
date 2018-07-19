<tr data-id="{{ $material->id }}">
    <td>{{ $material->material->material->parent->name }} - {{ $material->material->material->code }} - {{ $material->material->material->color }}</td> 
    <td>{{ $material->quantity }}</td> 
    <td>{{ $material->price }}</td> 
    <td>{{ $material->created_at }} </td> 
    <td>{{ $material->store_from->name }}</td>
    <td>{{ $material->store_to->name }}</td>
    <td>@if($material->status == 0) На път @else Приет @endif</td>

    <td>
        @if($material->storeTo == Auth::user()->store && $material->status == 0)
            <a href="/admin/materials/accept/{{$material->id}}" class="btn btn-primary" data-material="$material->id">Приеми</a>
        @else
            {{ $material->dateReceived }}
        @endif
    </td> 
</tr>