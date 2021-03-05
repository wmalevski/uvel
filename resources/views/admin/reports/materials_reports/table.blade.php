<tr data-id="{{ $materials_quantity->id }}">
    <td>{{$materials_quantity->material->name}} {{$materials_quantity->material->code}}, {{$materials_quantity->material->color}}</td>
    @foreach($stores as $store)
        @if($store->id == $materials_quantity->store_id)
            <td>{{$materials_quantity::where(array(
                'material_id' => $materials_quantity->material_id,
                'store_id'=>$store->id
                ))->first()->quantity}}
            </td>
        @else
            <td>0</td>
        @endif
    @endforeach
</tr>
