<tr>
        <td></td>
        <td>{{ App\Materials::find($material->type)->name }}</td> 
        <td>{{ $material->quantity }}</td> 
        <td>{{ $material->price }}</td> 
        <td>{{ $material->dateSent }}</td> 
        <td>@if($material->status == 0) На път @else Приет @endif</td>
    </tr>