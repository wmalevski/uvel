<tr>
    <td></td>
    <td> {{ $product->name }} </td>
    <td> {{ App\Jewels::find(App\Models::find($product->model)->jewel)->name }} </td> 
    <td> {{ App\Prices::find($product->price_list)->price }} </td> 
    <td> {{ $product->weight }} </td>
    <td> {{ (App\Prices::find($product->price_list)->price)*$product->weight }} </td>
    <td><a href="models/{{$product->id}}" class="edit-btn" data-toggle="modal" data-target="#editModel"><i class="c-brown-500 ti-pencil"></i></a></td>
</tr>

<tr>
    <th>камъни</th>
    <td>
        <table class="table table-condensed">
            <tr>
                <th>тип</th>
                <th>Брой</th>
            </tr>

            @foreach(App\Model_stones::where('model', $product->id)->get() as $stone)
                <tr>
                    <td>{{ App\Stones::find($stone->stone)->name }}</td>
                    <td>{{ $stone->amount }}</td>
                </tr>
            @endforeach
        </table>
        
    </td>
</tr>