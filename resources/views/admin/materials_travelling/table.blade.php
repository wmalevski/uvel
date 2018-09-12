<tr data-id="{{ $material->id }}">
    <td>{{ $material->material->material->parent->name }} - {{ $material->material->material->code }} - {{ $material->material->material->color }}</td> 
    <td>{{ $material->quantity }}</td> 
    <td>{{ $material->price }}</td> 
    <td>{{ $material->created_at }} </td> 
    <td>{{ $material->store_from->name }}</td>
    <td>{{ $material->store_to->name }}</td>
    <td>@if($material->dateReceived != '' && $material->status == 0) Отказан @elseif($material->status == 0) На път @else Приет @endif</td>

    @if($material->dateReceived)
        <td>
            {{ $material->dateReceived }}
        </td>
        @else 
        <td>
        </td>
    @endif

    @if($material->storeTo == Auth::user()->store && $material->status == 0)
        <td>
            <button type="button" data-travelstate="accept" class="btn btn-primary material--travelling_state" data-material="$material->id">Приеми</button>
            <button type="button" data-travelstate="decline" class="btn btn-primary material--travelling_state" data-material="$material->id">Откажи</button>
        </td> 

        @elseif($material->storeTo == Auth::user()->store && $material->status != 0) 
            <td>
                <button type="button" data-travelstate="accept" class="btn btn-primary material--travelling_state" data-material="$material->id" disabled>Приеми</button>
                <button type="button" data-travelstate="decline" class="btn btn-primary material--travelling_state" data-material="$material->id" disabled>Откажи</button>
        </td> 
    @endif
</tr>