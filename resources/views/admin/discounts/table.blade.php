@php
    $badgeColors = ['info', 'warning', 'success', 'danger', 'primary', 'secondary', 'dark'];
    $variant = $badgeColors[array_rand($badgeColors)];
@endphp

<tr data-id="{{ $discount->id }}">
    <td>
        <div style="display:flex;flex-direction:column;">
            <div class="barcode" style="text-align:center;">{!! generateBarcodeSVG($discount->barcode, "C128", 1, 33) !!}</div>
            <div class="barcode-identifier" style="text-align:center;">{{$discount->barcode}}</div>
        </div>
    </td>
    <td>{{ $discount->discount }}%</td> 
    <td>@if($discount->lifetime == 'yes') Безсрочна @else {{ $discount->expires }} @endif</td> 
    <td>@if($discount->active == 'yes') Валидна @else Невалидна @endif</td>
    <td>
        @forelse ( $discount->users as $user )
            <span class="badge badge-{{$variant}} p-2">{{$user->email}}</span>
        @empty
            N/A
        @endforelse
    </td>
    <td>
        @if ($discount->group)
            <span class="badge badge-{{$variant}} p-2">{{$discount->group->name}}</span>
        @else
            N/A
        @endif
    </td>
    @if($discount->id == 10)
        @dd($discount->payments)
    @endif
    <td>{{ count($discount->payments) }} @if(count($discount->payments) == 1) път @else пъти @endif</td>
    <td>
        <span data-url="discounts/{{$discount->id}}" class="edit-btn" data-form-type="edit" data-form="discounts" data-toggle="modal" data-target="#editDiscount"><i class="c-brown-500 ti-pencil"></i></span>
        <a data-print-label="true" target="_blank" href="/ajax/discounts/print/{{$discount->id}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a>
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
            <span data-url="discounts/delete/{{$discount->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
        @endif
    </td>
</tr>