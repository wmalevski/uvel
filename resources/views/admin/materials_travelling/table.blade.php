<tr>
    <td>{{ App\Materials::find(App\Materials_quantity::find($material->type)->material)->name }} - {{ App\Materials::find(App\Materials_quantity::find($material->type)->material)->code }} - {{ App\Materials::find(App\Materials_quantity::find($material->type)->material)->color }}</td> 
    <td>{{ $material->quantity }}</td> 
    <td>{{ $material->price }}</td> 
    <td></td> 
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