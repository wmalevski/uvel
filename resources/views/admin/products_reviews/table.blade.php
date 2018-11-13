<tr data-id="{{ $review->id }}">
    <td>{{ $review->user->name }}</td> 
    <td>{{ $review->title }}</td>
    <td>{{ $review->rating }}</td>
    <td>
        @if($review->product_id)
            {{ $review->product->name }}
        @elseif($review->model_id)
            {{ $review->model->name }}
        @elseif($review->product_others_id)
            {{ $review->productOther->name }}
        @endif
    </td>
    <td>
        <a href="{{ route('show_review', ['review' => $review->id]) }}"><i class="c-brown-500 ti-star"></i></a>        
        <span data-url="reviews/delete/{{$review->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>