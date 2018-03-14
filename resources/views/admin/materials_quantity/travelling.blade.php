<tr>
    <td></td>
    <td>{{ App\Materials::find($material->type)->name }} - {{ App\Materials::find($material->type)->code }} - {{ App\Materials::find($material->type)->color }}</td> 
    <td>{{ $material->quantity }}</td> 
    <td>{{ $material->price }}</td> 
    <td>{{ $material->dateSent }}</td> 
    <td>{{ App\Stores::find($material->storeTo)->name }}</td>
    <td>@if($material->status == 0) На път @else Приет @endif</td>

    <td>
        @if($material->storeTo == Auth::user()->store && $material->status == 0)
            <a href="/admin/materials/accept/{{$material->id}}" class="btn btn-primary" data-material="$material->id">Приеми</a>
        @else
            {{ $material->dateReceived }}
        @endif
    </td> 
</tr>