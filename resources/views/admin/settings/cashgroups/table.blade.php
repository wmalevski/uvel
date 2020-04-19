<tr data-id="{{ $cashgroup->id }}">
    <td>{{ $cashgroup->label }}</td> 
    <td>{{ $cashgroup->cash_group }}</td> 
    <td>
        <span data-url="settings/cashgroups/{{$cashgroup->id}}" class="edit-btn" data-form-type="edit" data-form="cashgroups" data-toggle="modal" data-target="#editCashGroup"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="settings/cashgroups/delete/{{$cashgroup->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>