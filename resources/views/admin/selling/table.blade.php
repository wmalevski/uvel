<tr @if($item->attributes->type == 'product') data-saleProduct @endif>
    <td>{{ $item->name }} {{ $item->id }}</th>
    <td data-quantity>{{ $item->quantity }}</td>
    <td data-weight="{{ $item->attributes->weight }}">{{ $item->attributes->weight }}</td>
    <td>{{ $item->price }}</td>
    <td style="display: none; visibility: hidden;" data-carat="{{ $item->attributes->carat }}">{{ $item->attributes->carat }}</td>
    <td><span data-url="/ajax/sell/removeItem/{{$item->id}}" class="delete-btn cart"><i class="c-brown-500 ti-trash"></i></span></td>
</tr>