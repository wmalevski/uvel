<tr data-id="{{ $model->id }}">
    <td> {{ $model->name }} </td>
    <td> {{ $model->jewel->name }} </td> 
    <td> {{ $model->weight }} </td>
    <td> {{ $model->workmanship }}лв. </td>
    <td> {{ $model->price }}лв. </td>
    <td>
        <span data-url="models/{{$model->id}}" class="edit-btn" data-toggle="modal" data-target="#editModel"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="models/delete/{{$model->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> 
        {{-- <i class="c-brown-500 ti-hummer" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="@foreach(App\ModelStone::where('model', $model->id)->get() as $stone)
                {{ App\Stones::find($stone->stone)->name }}
                {{ $stone->amount }}
            @endforeach"></i> --}}
    </td>

    <td class="stones--tooltip">
      Виж камъни
        <ul>
        @foreach($model->stones as $stone)
            
                <li>{{ $stone->stone->name }} , {{ $stone->amount }}</li>
        @endforeach
        </ul>
    </td>
</tr>