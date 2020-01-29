<tr data-id="{{ $type->id }}">
    <td> {{ $type->name }} </td>
    <td><span data-url="productsotherstypes/{{$type->id}}" class="edit-btn" data-form-type="edit" data-form="otherProductsTypes" data-toggle="modal" data-target="#editProductType"><i class="c-brown-500 ti-pencil"></i></span>
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
            <span data-url="productsotherstypes/delete/{{$type->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
        @endif
    </td>
</tr>