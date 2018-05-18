<tr data-id="{{ $repairType->id }}">
    <td>{{ $repairType->name }}</td> 
    <td>{{ $repairType->price }}</td> 
    <td>
        <span data-url="repairtypes/{{$repairType->id}}" class="edit-btn" data-toggle="modal" data-target="#editRepairType"><i class="c-brown-500 ti-pencil"></i></span>
        <a href="repairtypes/delete/{{$repairType->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></a>
    </td>
</tr>