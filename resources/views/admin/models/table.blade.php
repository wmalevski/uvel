
<tr data-id="{{ $model->id }}">
    <td class="thumbnail--tooltip">
        @if(count($model->photos))
            <button class="model-information-btn" data-toggle="modal" data-target="#modelInformation">
                <img class="admin-product-image" src="{{ asset("uploads/models/" . $model->photos->first()['photo']) }}">
            </button>
            <ul class="product-hover-image"
                style="background-image: url({{ asset("uploads/models/" . $model->photos->first()['photo']) }});"></ul>
        @endif
    </td>
    <td>{{$model->name}}</td>
    <td>{{$model->weight}} гр.</td>
    <td>@if($model->options->count()>0)
        @foreach($model->options as $option)
            @php($priceSell = $option->material->pricesSell->where('id', $option->retail_price_id))
            {{$option->material->name}} {{$option->material->code}}, {{$option->material->color}} | 
            @if(!empty($priceSell) && $priceSell->first())
              {{$priceSell->first()->price}} лв/гр
            @endif
        @endforeach
    @else
        Няма избран материал
    @endif</td>
    <td>{{$model->price}}лв.</td>
    <td>{{$model->workmanship}}лв.</td>
    @if(in_array(Auth::user()->role, array('admin', 'storehouse')))
    <td>
        <span data-url="models/{{$model->id}}" class="edit-btn" data-form-type="edit" data-form="models" data-toggle="modal" data-target="#editModel"><i class="c-brown-500 ti-pencil"></i></span>
        @if(Auth::user()->role == 'admin')
        <span data-url="models/delete/{{$model->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
        @endif
    </td>
    @endif
    <td>
        @if(!empty($model->stones->first()))
            {{ App\StoneContour::where('id', App\Stone::where('id', $model->stones->first()->stone_id)->first()->contour_id)->first()->name }}
            - {{ App\StoneSize::where('id', App\Stone::where('id', $model->stones->first()->stone_id)->first()->size_id)->first()->name }}
        @else
            Няма налични камъни
        @endif
    </td>

    <td class="stones--tooltip">
        @if(!empty($model->stones->first()))
            Виж камъни
            <ul>
                @foreach($model->stones as $stone)
                    <li>
                        Име: {{$stone->stone->nomenclature->name }} - {{$stone->stone->contour->name }}
                        - {{$stone->stone->size->name }} , Количество: {{ $stone->amount }}
                    </li>
                @endforeach
            </ul>
        @endif
    </td>
</tr>

