<tr data-id="{{ $repairType->id }}">
    <td>{{ $repairType->name }}</td> 
    <td>{{ $repairType->price }}</td> 
    <td>
        <span data-url="repairtypes/{{$repairType->id}}" class="edit-btn" data-form-type="edit" data-form="repairTypes" data-toggle="modal" data-target="#editRepairType"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="repairtypes/delete/{{$repairType->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>