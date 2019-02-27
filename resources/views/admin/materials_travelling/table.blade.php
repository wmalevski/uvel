<tr data-id="{{ $material->id }}">
    <td>{{ $material->material->material->parent->name }} - {{ $material->material->material->code }} - {{ $material->material->material->color }}</td> 
    <td>{{ $material->quantity }}гр.</td> 
    <td>{{ $material->price }}лв.</td> 
    <td>{{ $material->created_at }} </td> 
    <td>{{ $material->store_from->name }}</td>
    <td>{{ $material->store_to->name }}</td>
    <td>
        @if($material->dateReceived != '' && $material->status == 'not_accepted') 
                Отказан 
            @elseif($material->status == 'not_accepted' && $material->dateReceived == '') 
                На път 
            @else 
                Приет 
        @endif
    </td>

    <td>    
        @if($material->dateReceived)
            {{ $material->dateReceived }}
        @elseif($material->store_to_id == Auth::user()->getStore()->id && $material->status == 'not_accepted' && $material->dateReceived == '')
            <button type="button" data-travelstate="accept" class="btn btn-primary material--travelling_state" data-material="{{ $material->id }}">Приеми</button>
            <button type="button" data-travelstate="decline" class="btn btn-primary material--travelling_state" data-material="{{ $material->id }}">Откажи</button>
        @endif
    </td>

</tr>