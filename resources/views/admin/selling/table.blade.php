<tr>
    <td>{{ $item->name }}</th>
    <td>{{ $item->quantity }}</td>
    <td>{{ $item->attributes->weight }}</td>
    <td>{{ $item->price }}</td>
    <td><a href="sell/removeItem/{{$item->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></a></td>
</tr>