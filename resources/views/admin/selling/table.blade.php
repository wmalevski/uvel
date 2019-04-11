<tr @if($item->attributes->type == 'product') data-saleProduct data-type="{{ $item->attributes->mat }}" @endif>
    <td data-default-sample="{{ $item->attributes->defCode }}" data-sample="{{ $item->attributes->code }}" data-carat="{{ $item->attributes->carat }}">{{ $item->name }}</th>
    <td data-quantity>{{ $item->quantity }}</td>
    <td data-weight="{{ $item->attributes->weight }}">{{ $item->attributes->weight }}</td>
    <td>{{ $item->price }}</td>
    <td><span data-url="/ajax/sell/removeItem/{{$item->id}}" class="delete-btn cart"><i class="c-brown-500 ti-trash"></i></span></td>
    @if($item->attributes->order != '')
        <td style="display: none; visibility: hidden;" data-order-id="{{ $item->attributes->order }}"></td>
    @endif
 </tr>
