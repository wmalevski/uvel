<tr data-id="{{ $material->id }}">
    <td>{{ App\Materials_type::withTrashed()->find(App\Materials::withTrashed()->find(App\Materials_quantity::withTrashed()->find($material->type)->material)->parent)->name }} - {{ App\Materials::withTrashed()->find(App\Materials_quantity::withTrashed()->find($material->type)->material)->code }} - {{ App\Materials::withTrashed()->find(App\Materials_quantity::withTrashed()->find($material->type)->material)->color }}</td> 
    <td>{{ $material->quantity }}</td> 
    <td>{{ $material->price }}</td> 
    <td>{{ $material->created_at }} </td> 
    <td>{{ App\Stores::withTrashed()->find($material->storeFrom)->name }}</td>
    <td>{{ App\Stores::withTrashed()->find($material->storeTo)->name }}</td>
    <td>@if($material->status == 0) На път @else Приет @endif</td>

    <td>
        @if($material->storeTo == Auth::user()->store && $material->status == 0)
            <button type="button" data-travelstate="accept" class="btn btn-primary material--travelling_state" data-material="$material->id">Приеми</button>
            <button type="button" data-travelstate="decline" class="btn btn-primary material--travelling_state" data-material="$material->id">Откажи</button>
        @else
            {{ $material->dateReceived }}
        @endif
    </td> 
</tr>