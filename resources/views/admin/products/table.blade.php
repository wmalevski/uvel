<tr data-id="{{ $product->id }}">
    <td>{{ $product->code }}</td>
    <td> @if($product->model) {{ $product->model->name }} @endif </td>
    <td> @if($product->model) {{ $product->jewel->name }} @endif </td> 
    <td> {{ $product->retailPrice->price }} </td> 
    <td> {{ $product->weight }} </td>
    <td> {{ ($product->retailPrice->price)*$product->weight }} </td>
    <td>
        {!! DNS1D::getBarcodeSVG($product->barcode, "EAN13",1,33,"black", true) !!} {{ $product->barcode }}<br/> 
    </td>
 
    <td>
        @can('edit-products')
            <span data-url="products/{{$product->id}}" class="edit-btn" data-toggle="modal" data-target="#editProduct"><i class="c-brown-500 ti-pencil"></i></span> 
        @endcan
        <a href="products/print/{{$product->id}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a> 
        @can('delete-products')
            <span data-url="products/delete/{{$product->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> 
        @endcan
    </td>
</tr>