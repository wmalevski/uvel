<tr data-id="{{ $article->id }}">
    <td class="thumbnail--tooltip">
        {{ $article->title }}
        @foreach($article->thumbnail as $thumb)
            @if($thumb->language == 'bg')
                <ul style="background-image: url({{ asset("uploads/blog/" . $thumb->photo) }});">
            @endif
        @endforeach
        </ul>
    </td>

    <td>
            <a href="blog/{{$article->id}}/comments"><i class="ti-folder"></i></a>
            <span data-url="blog/{{$article->id}}" class="edit-btn" data-form-type="edit" data-form="blog" data-toggle="modal" data-target="#editArticle"><i class="c-brown-500 ti-pencil"></i></span> 
            <span data-url="blog/delete/{{$article->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> 
    </td>
</tr>