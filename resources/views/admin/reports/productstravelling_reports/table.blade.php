<tr data-id="{{ $products_travelling->id }}">
        <td>{{ \App\Product::where('id', $products_travelling->product_id)->first()->name }}</td>
        <td>{{ \App\Store::where('id',$products_travelling->store_from_id)->first()->id }}</td>
        <td>{{ $products_travelling->date_sent }}</td>
        <td>{{ \App\User::where('id',$products_travelling->user_sent)->first()->email }}</td>
        <td>{{ \App\Store::where('id',$products_travelling->store_to_id)->first()->id }}</td>
        <td>{{ $products_travelling->date_received }}</td>
        <td>{{ $products_travelling->user_received != null ? \App\User::where('id', $products_travelling->user_received)->first()->email : 'N/A' }}</td>
</tr>
