<tr data-id="{{ $expense->id }}">
    <td>{{ $expense->name }}</td> 
    <td><span data-url="expenses/{{$expense->id}}" class="edit-btn" data-toggle="modal" data-target="#editExpense" data-form-type="edit" data-form="expense"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="expenses/delete/{{$expense->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>