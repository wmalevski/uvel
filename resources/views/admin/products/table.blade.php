<tr>
    <td> {{ $product->code }} </td>
    <td> {{ $product->name }} </td>
    <td> {{ App\Jewels::find(App\Models::find($product->model)->jewel)->name }} </td> 
    <td> {{ App\Prices::find($product->retail_price)->price }} </td> 
    <td> {{ $product->weight }} </td>
    <td> {{ (App\Prices::find($product->retail_price)->price)*$product->weight }} </td>
    <td><a href="models/{{$product->id}}" class="edit-btn" data-toggle="modal" data-target="#editModel"><i class="c-brown-500 ti-pencil"></i></a></td>
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
       {!! DNS1D::getBarcodeHTML($product->id, "C128") !!}
       
       {{ $product->barcode }}
</td>