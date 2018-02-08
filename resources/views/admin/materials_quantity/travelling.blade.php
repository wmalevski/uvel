<tr>
        <td></td>
        <td>{{ App\Materials::find($material->type)->name }} - {{ App\Materials::find($material->type)->code }} - {{ App\Materials::find($material->type)->color }}</td> 
        <td>{{ $material->quantity }}</td> 
        <td>{{ $material->price }}</td> 
        <td>{{ $material->dateSent }}</td> 
        <td>@if($material->status == 0) На път @else Приет @endif</td>

        <td>
            @if($material->storeTo == Auth::user()->store && $material->status == 0)
                <a href="/acceptMaterial" class="btn btn-primary" data-toggle="modal" data-material="$material->id" data-target="#acceptMaterial">Приеми</a>
            @else
                {{ $material->dateReceived }}
            @endif
        </td> 
    </tr>