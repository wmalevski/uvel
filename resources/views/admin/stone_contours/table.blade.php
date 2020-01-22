<tr data-id="{{ $contour->id }}">
    <td>{{ $contour->name }}</td>
    <td>
        @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'storehouse']))
            <span data-url="stones/contours/{{$contour->id}}" class="edit-btn" data-form-type="edit" data-form="stoneContours" data-toggle="modal" data-target="#editContour"><i class="c-brown-500 ti-pencil"></i></span>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
            <span data-url="stones/contours/delete/{{$contour->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
        @endif
    </td>
</tr>