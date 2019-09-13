<tr data-id="{{ $products_travelling->id }}">
    @if($products_travelling->date_received)
        <td>{{ \App\Product::where('id', $products_travelling->product_id)->first()->name }}</td>
        <td>{{ \App\Store::where('id',$products_travelling->store_from_id)->first()->name }}</td>
        <td>{{ $products_travelling->date_sent }}</td>
        <td>{{ \App\User::where('id',$products_travelling->user_sent)->first()->name }}</td>
        <td>{{ \App\Store::where('id',$products_travelling->store_to_id)->first()->name }}</td>
        <td>{{ $products_travelling->date_received }}</td>
        <td>{{ \App\User::where('id', $products_travelling->user_received)->first()->name }}</td>
    @endif
</tr>
