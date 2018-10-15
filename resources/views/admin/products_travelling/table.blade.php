<tr data-id="{{ $product->id }}">
    <td>{{ App\Product::withTrashed()->find($product->product_id)->name }}</td> 
    <td>{{ $product->created_at }} </td> 
    <td>{{ App\Store::withTrashed()->find($product->store_from_id)->name }}</td>
    <td>{{ App\Store::withTrashed()->find($product->store_to_id)->name }}</td>
    <td>@if($product->status == 0) На път @else Приет @endif</td>

    <td>
        @if($product->store_to_id == Auth::user()->getStore()->id && $product->status == 0)
            <a href="/admin/productstravelling/accept/{{$product->id}}" class="btn btn-primary" data-material="{{ $product->id }}">Приеми</a>
        @else
            {{ $product->date_received }}
        @endif
    </td> 
</tr>