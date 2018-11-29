<tr data-id="{{ $comment->id }}">
    <td>{{ $comment->comment }}</td>
    <td>{{ $comment->author()->name }}</td>
    <td>{{ $comment->created_at }}</td>
    <td>
        <span data-url="blog/{{ $comment->blog_id }}/{{$comment->id}}/delete" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>