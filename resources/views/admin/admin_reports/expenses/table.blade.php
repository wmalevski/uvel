<tr data-id="{{ $expense->id }}">
    <td>{{ $expense->type->name }}</td> 
    <td>{{ $expense->amount }}</td>
    <td>{{ $expense->created_at->format('d.m.Y') }}</td>
    <td>{{ $expense->created_at->format('H:i') }}</td>
    <td>{{ $expense->store->name }}</td>
    <td>{{ $expense->additional_info }}</td> 
</tr>
    