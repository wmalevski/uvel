<tr data-id="{{ $type->id }}">
    <td>{{ $type->name }}</td> 
    <td>
        <span data-url="expensetypes/edit/{{$type->id}}" class="edit-btn" data-toggle="modal" data-target="#editExpenseType" data-form-type="edit" data-form="expenseTypes">
            <i class="c-brown-500 ti-pencil"></i>
        </span>
        <span data-url="expensetypes/delete/{{$type->id}}" class="delete-btn">
            <i class="c-brown-500 ti-trash"></i>
        </span>
    </td>
</tr>
