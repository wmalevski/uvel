<tr data-id="{{ $model->id }}">
    <td> {{ $model->name }} </td>
    <td> {{ App\Jewel::withTrashed()->find($model->jewel)->name }} </td> 
    <td> {{ App\Prices::withTrashed()->find($model->retail_price)->price }} </td> 
    <td> {{ App\Prices::withTrashed()->find($model->wholesale_price)->price }} </td> 
    <td> {{ $model->weight }} </td>
    <td> {{ (App\Prices::withTrashed()->find($model->retail_price)->price)*$model->weight }} </td>
    <td>
        <span data-url="models/{{$model->id}}" class="edit-btn" data-toggle="modal" data-target="#editModel"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="models/delete/{{$model->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> 
        {{-- <i class="c-brown-500 ti-hummer" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="@foreach(App\Model_stones::where('model', $model->id)->get() as $stone)
                {{ App\Stones::find($stone->stone)->name }}
                {{ $stone->amount }}
            @endforeach"></i> --}}
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

            @foreach(App\Model_stones::where('model', $model->id)->get() as $stone)
                <tr>
                    <td>{{ App\Stones::find($stone->stone)->name }}</td>
                    <td>{{ $stone->amount }}</td>
                </tr>
            @endforeach
        </table>
        
    </td>
</tr> --}}