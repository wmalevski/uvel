<tr data-id="{{ $product->id }}">
    <td> {!! DNS1D::getBarcodeSVG($product->barcode, "EAN13",1,33,"black", true) !!} <br/> {{ $product->barcode }}</td> 
    <td> {{ $product->name }} </td>
    <td> {{ $product->price }} </td>
    <td> {{ $product->quantity }} </td>
    <td> {{ $product->store->name}} </td>
    <td> {{ $product->code }} </td>
    <td>
        <span data-url="productsothers/{{$product->id}}" class="edit-btn" data-form-type="edit" data-form="otherProducts" data-toggle="modal" data-target="#editProduct"><i class="c-brown-500 ti-pencil"></i></span>
        <a href="productsothers/print/{{$product->id}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a>
        <span data-url="productsothers/delete/{{$product->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> 
    </td>
</tr>