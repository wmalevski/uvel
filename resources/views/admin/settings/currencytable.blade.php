<tr data-id="{{ $currency->id }}">
    <td>{{ $currency->name }}</td> 
    <td>{{ $currency->currency }}</td> 
    <td>
        <span data-url="settings/currencies/{{$currency->id}}" class="edit-btn" data-toggle="modal" data-target="#editCurrency"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="settings/currencies/delete/{{$currency->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>