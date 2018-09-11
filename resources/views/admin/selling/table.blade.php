<tr>
    <td>{{ $item->name }}</th>
    <td>{{ $item->quantity }}</td>
    <td>{{ $item->attributes->weight }}</td>
    <td>{{ $item->price }}</td>
    <td><span data-url="ajax/sell/removeItem/{{$item->id}}" class="delete-btn cart"><i class="c-brown-500 ti-trash"></i></span></td>
</tr>