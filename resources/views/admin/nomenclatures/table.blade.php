<tr data-id="{{ $nomenclature->id }}">
    <td>{{ $nomenclature->name }}</td>
    <td>
        @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'storehouse']))
            <span data-url="nomenclatures/{{$nomenclature->id}}" class="edit-btn" data-toggle="modal" data-form-type="edit" data-form="nomenclatures" data-target="#editNomenclature"><i class="c-brown-500 ti-pencil"></i></span>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
             <span data-url="nomenclatures/delete/{{$nomenclature->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
        @endif
    </td>
</tr>
