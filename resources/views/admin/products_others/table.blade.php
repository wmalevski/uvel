<tr data-id="{{ $product->id }}">
    <td> {!! DNS1D::getBarcodeSVG($product->barcode, "EAN13",1,33,"black", true) !!} </td> 
    <td> {{ $product->name }} </td>
    <td> {{ $product->price }} </td>
    <td> {{ $product->quantity }} </td>
    <td> {{ App\Store::withTrashed()->find($product->store_id)->name}} </td>
    <td> {{ $product->code }} </td>
    <td>
        <span data-url="productsothers/{{$product->id}}" class="edit-btn" data-toggle="modal" data-target="#editProduct"><i class="c-brown-500 ti-pencil"></i></span>
        <a href="productsothers/print/{{$product->id}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a>
        <span data-url="productsothers/delete/{{$product->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> 
    </td>
</tr>