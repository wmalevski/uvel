<tr data-id="{{ $materials_quantity->id }}">
    <td>{{ \App\Material::where('id', $materials_quantity->material_id)->first()->name }}
        - {{ \App\Material::where('id', $materials_quantity->material_id)->first()->code }}
        - {{ \App\Material::where('id', $materials_quantity->material_id)->first()->color }}</td>
    @foreach($stores as $store)
        @if($store->id == $materials_quantity->store_id)
            <td>{{ \App\MaterialQuantity::where('store_id', $store->id)->first()->quantity }}</td>
        @else
            <td>0</td>
        @endif
    @endforeach
</tr>
