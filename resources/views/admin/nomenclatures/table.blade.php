<tr data-id="{{ $nomenclature->id }}">
    <td>{{ $nomenclature->name }}</td> 
    <td>
        <span data-url="nomenclatures/{{$nomenclature->id}}" class="edit-btn" data-toggle="modal" data-form-type="edit" data-form="nomenclatures" data-target="#editNomenclature"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="nomenclatures/delete/{{$nomenclature->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>
