<tr data-id="{{ $style->id }}">
    <td>{{ $style->name }}</td>
    @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
        <td>
            <span data-url="stones/styles/{{$style->id}}" class="edit-btn" data-form-type="edit" data-form="stoneStyles" data-toggle="modal" data-target="#editStyle"><i class="c-brown-500 ti-pencil"></i></span>
            <span data-url="stones/styles/delete/{{$style->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
        </td>
    @endif
</tr>   