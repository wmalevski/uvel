<tr data-id="{{ $product->id }}">
    <td class="thumbnail--tooltip">
        {{ $product->code }}
        <ul @if($product->photos) style="background-image: url({{ asset("uploads/products/" . $product->photos->first()['photo']) }});" @endif>
        </ul>
    </td>
    <td> @if($product->model) {{ $product->model->name }} @endif </td>
    <td> @if($product->model) {{ $product->jewel->name }} @endif </td> 
    <td> {{ $product->retailPrice->price }} </td> 
    <td> {{ $product->weight }} </td>
    <td> {{ $product->price }} </td>
    {{-- <td> {{ ($product->retailPrice->price)*$product->weight }} </td> --}}
    <td>
        {!! DNS1D::getBarcodeSVG($product->barcode, "EAN13",1,33,"black", true) !!} <br/> {{ $product->barcode }}<br/> 
    </td>

    <td>@if($product->status == 'selling') <span class="badge bgc-deep-purple-50 c-deep-purple-700 p-10 lh-0 tt-c badge-pill">В продажба</span> @elseif($product->status == 'sold') <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Продаден</span> @elseif($product->status == 'travelling') <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">На път</span> @else <span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">Наличен</span>  @endif</td> 
 
    <td>
        @can('edit-products')
            <span data-url="products/{{$product->id}}" class="edit-btn" data-form-type="edit" data-form="products" data-toggle="modal" data-target="#editProduct"><i class="c-brown-500 ti-pencil"></i></span> 
        @endcan
        
        <a href="products/print/{{$product->id}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a> 

        @can('delete-products')
            <span data-url="products/delete/{{$product->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> 
        @endcan
    </td>
</tr>