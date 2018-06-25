<tr data-id="{{ $product->id }}">
    <td>{{ $product->code }}</td>
    <td> @if($product->model) @if(App\Jewels::withTrashed()->find(App\Models::withTrashed()->find($product->model)->jewel)) {{ App\Jewels::find(App\Models::withTrashed()->find($product->model)->jewel)->name }} @endif @endif </td> 
    <td> {{ App\Prices::withTrashed()->find($product->retail_price)->price }} </td> 
    <td> {{ $product->weight }} </td>
    <td> {{ (App\Prices::withTrashed()->find($product->retail_price)->price)*$product->weight }} </td>
    <td>
         {!! DNS1D::getBarcodeSVG($product->barcode, "EAN13",1,33,"black", true) !!} <br/> 
        {{--  {!! '<img src="' . DNS1D::getBarcodePNG("4", "C39+",3,33,array(1,1,1), true) . '" alt="barcode"   />' !!}  --}}
        {{--  {!! DNS1D::getBarcodePNGPath("4445645656", "PHARMA2T",3,33,array(255,255,0), true) !!}  --}}
        {{--  {!! '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("256874214568", "EAN13",1,33,array(1,1,1), true) . '" alt="barcode"   />' !!}  <br/>  --}}
        {{--  {{ $product->barcode }}  --}}
        {{--  {{ $product->barcode }}  --}}
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

{{-- <tr>
    <th>камъни</th>
    <td>
        <table class="table table-condensed">
            <tr>
                <th>Тип</th>
                <th>Брой</th>
            </tr>

            @foreach(App\Product_stones::withTrashed()->where('product', $product->id)->get() as $stone)
                <tr>
                    <td> @if(App\Stones::withTrashed()->find($stone->stone)) {{App\Stones::withTrashed()->find($stone->stone)->name}} @endif</td>
                    <td>{{ $stone->amount }}</td>
                </tr>
            @endforeach
        </table>
        
    </td>
</tr> --}}