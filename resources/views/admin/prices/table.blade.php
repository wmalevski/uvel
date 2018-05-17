<tr data-id="{{ $price->id }}">
    <td> @if(!empty($loop)) @if ($loop->first) Индикация за образуване на цена @endif @endif </td>
    <td>{{ $price->slug }}</td> 
    <td>{{ $price->price }}</td> 
    <td>
        <span data-url="prices/edit/{{$price->id}}" class="edit-btn" data-toggle="modal" data-target="#editPrice"><i class="c-brown-500 ti-pencil"></i></span>
        <a href="delete/{{$price->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></a> 
    </td>
</tr>