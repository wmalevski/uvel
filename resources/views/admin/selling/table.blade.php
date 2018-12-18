<tr data-calculated-weight="@if($item->attributes->calculated_weight != 0){{ $item->attributes->calculated_weight }}@endif">
    <td>{{ $item->name }} {{ $item->id }}</th>
    <td>{{ $item->quantity }}</td>
    <td>{{ $item->attributes->weight }} (@if($item->attributes->calculated_weight != 0){{ $item->attributes->calculated_weight }}гр в 14 карата) @endif</td>
    <td>{{ $item->price }}</td>
    <td><span data-url="/ajax/sell/removeItem/{{$item->id}}" class="delete-btn cart"><i class="c-brown-500 ti-trash"></i></span></td>
</tr>