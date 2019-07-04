<tr @if($item->attributes->type == 'product') data-saleProduct @endif>
    @if($item->attributes->type == 'product')
        <td>{{ App\Product::where('id', $item->attributes->product_id)->first()->model->name }} {{ App\Product::where('id', $item->attributes->product_id)->first()->code }}</th>
    @elseif($item->attributes->type == 'box')
        <td>{{ App\ProductOther::where('id', $item->attributes->product_id)->first()->name }} {{ App\ProductOther::where('id', $item->attributes->product_id)->first()->code }}</th>
    @endif
    <td data-quantity>{{ $item->quantity }}</td>
    <td data-weight="{{ $item->attributes->weight }}">{{ $item->attributes->weight }}</td>
    <td>{{ $item->price }}</td>
    <td style="display: none; visibility: hidden;" data-carat="{{ $item->attributes->carat }}">{{ $item->attributes->carat }}</td>
    <td><span data-url="/ajax/sell/removeItem/{{$item->id}}" class="delete-btn cart"><i class="c-brown-500 ti-trash"></i></span></td>
    @if($item->attributes->order != '')
        <td style="display: none; visibility: hidden;" data-order-id="{{ $item->attributes->order }}"></td>
    @endif
</tr>