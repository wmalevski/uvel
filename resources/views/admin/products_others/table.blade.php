<tr>
    <td> {!! DNS1D::getBarcodeSVG($product->barcode, "EAN13",1,33,"black", true) !!} <br/>
         {{ $product->barcode }} 
    </td>
    <td> {{ $product->model }} </td>
    <td> {{ $product->price }} </td>
    <td> {{ $product->quantity }} </td>
    <td><a href="productsothers/{{$product->id}}" class="edit-btn" data-toggle="modal" data-target="#editProduct"><i class="c-brown-500 ti-pencil"></i></a></td>
</tr>