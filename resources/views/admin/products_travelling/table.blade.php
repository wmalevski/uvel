<tr data-id="{{ $product->id }}">
    <td class="thumbnail--tooltip">
        @php
            $prod=App\Product::withTrashed()->find($product->product_id);

            if($prod){
                $prodPhoto=$prod->photos->first();
                $prodPhoto=($prodPhoto && isset($prodPhoto['photo'])?$prodPhoto['photo']:null);
            }

            $mod=App\Product::withTrashed()->find($product->product_id);
            if($mod){
                $modPhoto=$mod->model->photos->first();
                $modPhoto=($modPhoto && isset($modPhoto['photo'])?$modPhoto['photo']:null);
            }
        @endphp
        @if($prod && $prodPhoto)
            <img class="admin-product-image" src="{{ asset("uploads/products/".$prodPhoto)}}">
            <ul class="product-hover-image" style="background-image: url({{ asset("uploads/products/". $prodPhoto) }});"></ul>
        @elseif($mod && $modPhoto)
            <img class="admin-product-image" src="{{ asset("uploads/models/".$modPhoto) }}">
            <ul class="product-hover-image" style="background-image: url({{ asset("uploads/models/". $modPhoto) }});"></ul>
        @endif
    </td>
    <td>{{ $product->product_id }}</td>
    <td>@if($prod) {{ $prod->weight }} @endif</td>
    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $product->created_at)->format('H:i d/m/Y') }} </td>
    <td>@if($product->store_to_id == Auth::user()->getStore()->id && $product->status == 0) Потвърди приемане на продукт
    @elseif($product->status == 1) {{ $product->date_received ? $product->date_received->format('H:i d/m/Y') : '' }}
    @else В изчакване на потвърждение от {{ App\Store::withTrashed()->find($product->store_to_id)->name }}
    @endif
    </td>
    <td>{{ App\Store::withTrashed()->find($product->store_from_id)->name }}</td>
    <td>{{ App\Store::withTrashed()->find($product->store_to_id)->name }}</td>
    <td>@if($product->status == 0) На път @else Приет @endif</td>
    <td>
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin' && $product->status == 0)
        <span data-url="productstravelling/delete/{{$product->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
        @endif
    </td>
</tr>