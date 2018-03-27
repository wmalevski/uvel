<tr>
    <td></td>
    <td>{{ $discount->code }}</td> 
    <td>{{ $discount->barcode }}</td> 
    <td>{{ $discount->discount }}%</td> 
    <td>{{ $discount->expires }}</td> 
    <td>@if($discount->active == 'yes') Валидна @else Невалидна @endif</td> 
    <td>@if($discount->user) {{ App\User::find($discount->user)->name }} @endif</td>
    <td><a href="discounts/{{$discount->id}}" class="edit-btn" data-toggle="modal" data-target="#editDiscount"><i class="c-brown-500 ti-pencil"></i></a></td>
</tr>