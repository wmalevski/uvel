<tr data-id="{{ $slide->id }}">
        <td class="thumbnail--tooltip">
            <ul  style="background-image: url({{ asset("uploads/slides/" . $slide->photo) }});">
                </ul>
                {{$slide->title}}
        </td>
        <td>{{ $slide->content }}</td>
        <td>{{ $slide->button_text }}</td>
        <td>{{ $slide->button_link }}</td>    
        <td> 
            <span data-url="slides/delete/{{$slide->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
        </td>
    </tr>