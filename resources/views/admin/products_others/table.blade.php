@php
    $productImg=$product->photos->first();
    $productImg=(isset($productImg['photo'])?$productImg['photo']:null);
@endphp
<tr data-id="{{ $product->id }}">
    <td>
        @if($productImg)
            <img class="admin-product-image" src="{{ getPhoto("products_others/".$productImg) }}">
        @else
            <p>Няма снимка</p>
        @endif
    </td>
    <td>{{ $product->id }}</td>
    
    <td>
        <div style="display:flex;flex-direction:column;">
            <div class="barcode" style="text-align:center;">{!! generateBarcodeSVG($product->barcode, "EAN13", 1, 33) !!}</div>
            <div class="barcode-identifier" style="text-align:center;">{{$product->barcode}}</div>
        </div>
    </td>
    <td> {{ $product->name }} </td>
    <td> {{ $product->price }} </td>
    <td> {{ $product->quantity }} </td>
    <td> {{ $product->store->id}} </td>
    <td>
        @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'storehouse']))
            <span data-url="productsothers/{{$product->id}}" class="edit-btn" data-form-type="edit"
                  data-form="otherProducts" data-toggle="modal" data-target="#editProduct"><i
                        class="c-brown-500 ti-pencil"></i></span>
        @endif
        <a data-print-label="true" target="_blank" href="/ajax/productsothers/generatelabel/{{$product->barcode}}"
           class="print-btn"><i class="c-brown-500 ti-printer"></i></a>
        @if(\Illuminate\Support\Facades\Auth::user()->role =='admin')
            <span data-url="productsothers/delete/{{$product->id}}" class="delete-btn"><i
                        class="c-brown-500 ti-trash"></i></span>
        @endif
    </td>
</tr>