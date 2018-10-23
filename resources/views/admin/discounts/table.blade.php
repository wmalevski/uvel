<tr data-id="{{ $discount->id }}">
    <td>{!! DNS1D::getBarcodeSVG($discount->barcode, "EAN13",1,33,"black", true) !!} <br/> {{ $discount->barcode }}</td>
    <td>{{ $discount->discount }}%</td> 
    <td>@if($discount->lifetime == 'yes') Безсрочна @else {{ $discount->expires }} @endif</td> 
    <td>@if($discount->active == 'yes') Валидна @else Невалидна @endif</td> 
    <td>@if($discount->user) {{ $discount->user->name }} @endif</td>
    <td>{{ count($discount->payments()) }} @if(count($discount->payments()) == 1) път @else пъти @endif</td>
    <td>
        <span data-url="discounts/{{$discount->id}}" class="edit-btn" data-form-type="edit" data-form="discounts" data-toggle="modal" data-target="#editDiscount"><i class="c-brown-500 ti-pencil"></i></span>
        <a href="discounts/print/{{$discount->id}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a> 
        <span data-url="discounts/delete/{{$discount->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>