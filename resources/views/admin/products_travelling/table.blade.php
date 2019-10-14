<tr data-id="{{ $product->id }}">
    <td class="thumbnail--tooltip">
        @if( App\Product::withTrashed()->find($product->product_id)->photos)
            <img class="admin-product-image" src="{{ asset("uploads/products/" .  App\Product::withTrashed()->find($product->product_id)->photos->first()['photo']) }}">
            <ul class="product-hover-image" style="background-image: url({{ asset("uploads/products/". App\Product::withTrashed()->find($product->product_id)->photos->first()['photo']) }});"></ul>
        @elseif( App\Product::withTrashed()->find($product->product_id)->model)
            <img class="admin-product-image" src="{{ asset("uploads/models/" .  App\Product::withTrashed()->find($product->product_id)->model->photos->first()['photo']) }}">
            <ul class="product-hover-image" style="background-image: url({{ asset("uploads/models/". App\Product::withTrashed()->find($product->product_id)->model->photos->first()['photo']) }});"></ul>
        @endif
    </td>
    <td>{{ App\Product::withTrashed()->find($product->product_id)->id }}</td>
    <td>{{ App\Product::withTrashed()->find($product->product_id)->weight }}</td>
    <td>
        @if($product->store_to_id == Auth::user()->getStore()->id && $product->status == 0)
            <a href="/admin/productstravelling/accept/{{$product->id}}" class="btn btn-primary" data-material="{{ $product->id }}">Приеми</a>
        @elseif($product->status == 1)
            {{ $product->date_received }}
        @else
            В изчакване на потвърждение
        @endif
    </td>
    <td>{{ $product->created_at }} </td> 
    <td>{{ App\Store::withTrashed()->find($product->store_from_id)->name }}</td>
    <td>{{ App\Store::withTrashed()->find($product->store_to_id)->name }}</td>
    <td>@if($product->status == 0) На път @else Приет @endif</td>
    <td>
        @if($product->status == 0)
            <span data-url="productstravelling/delete/{{$product->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
        @endif
    </td>
</tr>