<tr data-id="{{ $article->id }}">
    <td class="thumbnail--tooltip">
        {{ $article->title }}
        <ul @if($article->thumbnail) style="background-image: url({{ asset("uploads/blog/" . $article->thumbnail) }});" @endif>
        </ul>
    </td>

    <td>
            <a href="blog/{{$article->id}}/comments"><i class="ti-folder"></i></a>
        {{-- @can('edit-products') --}}
            <span data-url="blog/{{$article->id}}" class="edit-btn" data-form-type="edit" data-form="blog" data-toggle="modal" data-target="#editArticle"><i class="c-brown-500 ti-pencil"></i></span> 
        {{-- @endcan --}}

        {{-- @can('delete-products') --}}
            <span data-url="blog/delete/{{$article->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span> 
        {{-- @endcan --}}
    </td>
</tr>