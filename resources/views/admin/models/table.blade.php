<tr data-id="{{ $model->id }}">
    <td class="thumbnail--tooltip">
        {{ $model->name }}
        <ul>@if($model->photos) <img src="{{ asset("uploads/models/" . $model->photos->first()['photo']) }}" alt="" class="img-responsive" /> @endif</ul>
    </td>
    <td> {{ $model->jewel->name }} </td> 
    <td> {{ $model->weight }} </td>
    <td> {{ $model->workmanship }}лв. </td>
    <td> {{ $model->price }}лв. </td>
    <td>
        <span data-url="models/{{$model->id}}" class="edit-btn" data-form-type="edit" data-form="models" data-toggle="modal" data-target="#editModel"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="models/delete/{{$model->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> 
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