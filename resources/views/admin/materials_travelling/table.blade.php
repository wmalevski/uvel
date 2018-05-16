<tr data-id="{{ $material->id }}">
    <td>{{ App\Materials::withTrashed()->find(App\Materials_quantity::withTrashed()->find($material->type)->material)->name }} - {{ App\Materials::withTrashed()->find(App\Materials_quantity::withTrashed()->find($material->type)->material)->code }} - {{ App\Materials::withTrashed()->find(App\Materials_quantity::withTrashed()->find($material->type)->material)->color }}</td> 
    <td>{{ $material->quantity }}</td> 
    <td>{{ $material->price }}</td> 
    <td>{{ $material->created_at }} </td> 
    <td>{{ App\Stores::withTrashed()->find($material->storeTo)->name }}</td>
    <td>@if($material->status == 0) На път @else Приет @endif</td>

    <td>
        @if($material->storeTo == Auth::user()->store && $material->status == 0)
            <a href="/admin/materials/accept/{{$material->id}}" class="btn btn-primary" data-material="$material->id">Приеми</a>
        @else
            {{ $material->dateReceived }}
        @endif
    </td> 
</tr>