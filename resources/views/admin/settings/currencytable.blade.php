<tr>
    <td>{{ $currency->name }}</td> 
    <td>{{ $currency->currency }}</td> 
    <td>
        <a href="settings/currencies/{{$currency->id}}" class="edit-btn" data-toggle="modal" data-target="#editCurrency"><i class="c-brown-500 ti-pencil"></i></a>
        <a href="currencies/delete/{{$currency->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></a>
    </td>
</tr>