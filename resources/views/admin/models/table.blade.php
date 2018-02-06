<tr>
    <td></td>
    <td> {{ $model->name }} </td>
    <td> {{ App\Jewels::find($model->jewel)->name }} </td> 
    <td> {{ App\Prices::find($model->retail_price)->price }} </td> 
    <td> {{ $model->weight }} </td>
    <td> {{ (App\Prices::find($model->retail_price)->price)*$model->weight }} </td>
    <td><a href="models/{{$model->id}}" class="edit-btn" data-toggle="modal" data-target="#editModel"><i class="c-brown-500 ti-pencil"></i></a></td>
</tr>

<tr>
    <th>камъни</th>
    <td>
        <table class="table table-condensed">
            <tr>
                <th>тип</th>
                <th>Брой</th>
            </tr>

            @foreach(App\Model_stones::where('model', $model->id)->get() as $stone)
                <tr>
                    <td>{{ App\Stones::find($stone->stone)->name }}</td>
                    <td>{{ $stone->amount }}</td>
                </tr>
            @endforeach
        </table>
        
    </td>
</tr>