<tr data-id="{{ $item->id }}">
    <td class="thumbnail--tooltip">
        @php
            $prod=$item->product;
            if($prod){
                $prodPhoto=$prod->photos->first();
                $prodPhoto=($prodPhoto && isset($prodPhoto['photo'])?$prodPhoto['photo']:null);
            }
        @endphp
        @if($prod && $prodPhoto)
            <img class="admin-product-image" src="{{ getPhoto("uploads/products/".$prodPhoto)}}">
            <ul class="product-hover-image" style="background-image: url({{ getPhoto("uploads/products/". $prodPhoto) }});"></ul>
        @endif
    </td>
    <td>{{ $item->product_id }}</td>
    <td>@if($prod) {{ $prod->weight }} @endif</td>
    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('H:i d/m/Y') }} </td>
    <td>@if($item->store_to_id == $userStoreId && $item->status == 0) Потвърди приемане на продукт
    @elseif($item->status == 1) {{ $item->date_received ? (new Carbon\Carbon)->format('H:i d/m/Y', $item->date_received) : '' }}
    @else В изчакване на потвърждение от {{ $item->storeTo->name }}
    @endif
    </td>
    <td>{{ $item->storeFrom->name }}</td>
    <td>{{ $item->storeTo->name }}</td>
    <td>@if($item->status == 0) На път @else Приет @endif</td>
    <td>
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin' && $item->status == 0)
        <span data-url="productstravelling/delete/{{$item->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
        @endif
    </td>
</tr>