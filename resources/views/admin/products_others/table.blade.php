<tr>
    <td> {!! DNS1D::getBarcodeSVG($product->barcode, "EAN13",1,33,"black", true) !!} </td> 
    <td> {{ $product->name }} </td>
    <td> {{ $product->price }} </td>
    <td> {{ $product->quantity }} </td>
    <td>
        <a href="productsothers/{{$product->id}}" class="edit-btn" data-toggle="modal" data-target="#editProduct"><i class="c-brown-500 ti-pencil"></i></a>
        <a href="productsothers/print/{{$product->id}}" class="edit-btn"><i class="c-brown-500 ti-printer"></i></a>
        <a href="productsothers/{{$product->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></a> 
    </td>
</tr>