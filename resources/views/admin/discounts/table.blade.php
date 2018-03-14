<tr>
    <td></td>
    <td>{{ $discount->code }}</td> 
    <td>{{ $discount->barcode }}</td> 
    <td>{{ $discount->discount }}%</td> 
    <td>{{ $discount->expires }}</td> 
    <td>@if($discount->active == 'yes') Да @else Не @endif</td> 
    <td>{{ App\User::find($discount->user)->name }}</td>
</tr>