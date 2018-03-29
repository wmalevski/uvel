<tr>
    <td> {{ $product->name }} </td>
    <td> {{ App\Jewels::find(App\Models::find($product->model)->jewel)->name }} </td> 
    <td> {{ App\Prices::find($product->retail_price)->price }} </td> 
    <td> {{ $product->weight }} </td>
    <td> {{ (App\Prices::find($product->retail_price)->price)*$product->weight }} </td>
    <td>
        <a href="models/{{$product->id}}" class="edit-btn" data-toggle="modal" data-target="#editModel"><i class="c-brown-500 ti-pencil"></i></a> 
        <a href="models/print/{{$product->id}}" class="edit-btn"><i class="c-brown-500 ti-printer"></i></a> 
    </td>
</tr>

<tr>
    <th>камъни</th>
    <td>
        <table class="table table-condensed">
            <tr>
                <th>Тип</th>
                <th>Брой</th>
            </tr>

            @foreach(App\Product_stones::where('product', $product->id)->get() as $stone)
                <tr>
                    <td>{{ App\Stones::find($stone->stone)->name }}</td>
                    <td>{{ $stone->amount }}</td>
                </tr>
            @endforeach
        </table>
        
    </td>
</tr>

<td>
       {{--  {!! DNS1D::getBarcodeSVG($product->barcode, "EAN13",1,33,"black", true) !!} <br/>  --}}
       {{--  {!! '<img src="' . DNS1D::getBarcodePNG("4", "C39+",3,33,array(1,1,1), true) . '" alt="barcode"   />' !!}  --}}
       {{--  {!! DNS1D::getBarcodePNGPath("4445645656", "PHARMA2T",3,33,array(255,255,0), true) !!}  --}}
       {{--  {!! '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("256874214568", "EAN13",1,33,array(1,1,1), true) . '" alt="barcode"   />' !!}  <br/>  --}}
       {{--  {{ $product->barcode }}  --}}
       {{--  {{ $product->barcode }}  --}}
</td>