<tr data-id="{{ $type->id }}">
    <td> {{ $type->name }} </td>
    <td><span data-url="productsotherstypes/{{$type->id}}" class="edit-btn" data-toggle="modal" data-target="#editProductType"><i class="c-brown-500 ti-pencil"></i></span>
    <span data-url="productsotherstypes/delete/{{$type->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span></td>
</tr>