<!--<tr @if($item->attributes->type == 'product') data-saleProduct @endif>
    <td data-default-sample="585" data-sample="989" data-carat="{{ $item->attributes->carat }}">{{ $item->name }} {{ $item->id }}</th>
    <td data-quantity>{{ $item->quantity }}</td>
    <td data-weight="{{ $item->attributes->weight }}">{{ $item->attributes->weight }}</td>
    <td>{{ $item->price }}</td>
    <td><span data-url="/ajax/sell/removeItem/{{$item->id}}" class="delete-btn cart"><i class="c-brown-500 ti-trash"></i></span></td>
    @if($item->attributes->order != '')
        <td style="display: none; visibility: hidden;" data-order-id="{{ $item->attributes->order }}"></td>
    @endif
</tr>
-->

<tr data-saleProduct data-type="2">
    <td data-default-sample="585" data-sample="989" data-carat="14">Product Srebro</th>
    <td data-quantity>1</td>
    <td data-weight="5">5</td>
    <td>350</td>
    <td><span data-url="/ajax/sell/removeItem/5" class="delete-btn cart"><i class="c-brown-500 ti-trash"></i></span></td>
</tr>
<tr data-saleProduct data-type="2">
    <td data-default-sample="585" data-sample="989" data-carat="14">Product Srebro</th>
    <td data-quantity>1</td>
    <td data-weight="5">5</td>
    <td>350</td>
    <td><span data-url="/ajax/sell/removeItem/5" class="delete-btn cart"><i class="c-brown-500 ti-trash"></i></span></td>
</tr>
<tr data-saleProduct data-type="1">
    <td data-default-sample="645" data-sample="989" data-carat="14">Product Gold</th>
    <td data-quantity>1</td>
    <td data-weight="6">5</td>
    <td>450</td>
    <td><span data-url="/ajax/sell/removeItem/5" class="delete-btn cart"><i class="c-brown-500 ti-trash"></i></span></td>
</tr>
<tr data-saleProduct data-type="1">
    <td data-default-sample="645" data-sample="989" data-carat="14">Product Gold</th>
    <td data-quantity>1</td>
    <td data-weight="6">5</td>
    <td>450</td>
    <td><span data-url="/ajax/sell/removeItem/5" class="delete-btn cart"><i class="c-brown-500 ti-trash"></i></span></td>
</tr>