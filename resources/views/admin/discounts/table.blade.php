<tr data-id="{{ $discount->id }}">
    <td>{!! DNS1D::getBarcodeSVG($discount->barcode, "EAN13",1,33,"black", true) !!}</td>
    <td>{{ $discount->discount }}%</td> 
    <td>@if($discount->lifetime == 'yes') Безсрочна @else {{ $discount->expires }} @endif</td> 
    <td>@if($discount->active == 'yes') Валидна @else Невалидна @endif</td>
    <td>
        @foreach($discount->users as $user)
            @php
                $badgeColors = ['info', 'warning', 'success', 'danger', 'primary', 'secondary', 'dark'];
                $variant = $badgeColors[array_rand($badgeColors)];
            @endphp
            <span class="badge badge-{{$variant}} p-2">{{$user->email}}</span>
        @endforeach
    </td>
    <td>{{ count($discount->payments) }} @if(count($discount->payments) == 1) път @else пъти @endif</td>
    <td>
        <span data-url="discounts/{{$discount->id}}" class="edit-btn" data-form-type="edit" data-form="discounts" data-toggle="modal" data-target="#editDiscount"><i class="c-brown-500 ti-pencil"></i></span>
        <a data-print-label="true" target="_blank" href="/ajax/discounts/print/{{$discount->id}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a>
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
            <span data-url="discounts/delete/{{$discount->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
        @endif
    </td>
</tr>