<tr data-id="{{ $product->id }}">
    <td>{{ \App\Material::where('id',$product->material_id)->first()->name }}
        - {{ \App\Material::where('id',$product->material_id)->first()->code }}
        - {{ \App\Material::where('id',$product->material_id)->first()->color }}</td>
    @foreach($stores as $store)
        @if($store->id == $product->store_id)
            <td>{{ $product->count}}</td>
        @else
            <td>0</td>
        @endif
    @endforeach
</tr>