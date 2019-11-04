<tr data-id="{{ $materials_travelling->id }}">
    @if($materials_travelling->dateReceived)
        <td>{{ \App\Material::where('id', $materials_travelling->material_id)->first()->name }}
            - {{ \App\Material::where('id', $materials_travelling->material_id)->first()->code }}
            - {{ \App\Material::where('id', $materials_travelling->material_id)->first()->color }}</td>
        <td>{{ $materials_travelling->quantity }}</td>
        <td>{{ \App\Store::where('id',$materials_travelling->store_from_id)->first()->name }}</td>
        <td>{{ $materials_travelling->dateSent }}</td>
        <td>{{ \App\User::where('id',$materials_travelling->user_sent_id)->first()->email }}</td>
        <td>{{ \App\Store::where('id',$materials_travelling->store_to_id)->first()->name }}</td>
        <td>{{ $materials_travelling->dateReceived }}</td>
        <td>{{ \App\User::where('id',$materials_travelling->user_received_id)->first()->email}}</td>
    @endif
</tr>
