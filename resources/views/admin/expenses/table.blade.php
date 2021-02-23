<tr data-id="{{ $expense->id }}">
    <td>{{ $expense->type->name }}</td>
    <td>{{ $expense->amount }}</td>
    <td>{{ $expense->store_from_id ? $expense->store_from_id : 'Няма данни' }}</td>
    <td>{{ $expense->store_to_id ? $expense->store_to_id : 'Няма данни' }}</td>
    <td>
        @if($expense->currency_id)
        {{$expense->currency}}
        @else
        {{$currency::where('default', 'yes')->first()->name}}
        @endif
    </td>
    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $expense->created_at)->format('H:i d/m/Y') }}</td>
    <td>{{ $expense->additional_info }}</td>
    @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
        <td><span data-url="expenses/{{$expense->id}}" class="edit-btn" data-toggle="modal" data-target="#editExpense" data-form-type="edit" data-form="expenses"><i class="c-brown-500 ti-pencil"></i></span>
            <span data-url="expenses/delete/{{$expense->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
        </td>
    @endif
</tr>
