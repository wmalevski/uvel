<tr data-id="{{ $review->id }}">
    <td>
      <img class="admin-product-image" src="{{ asset("uploads/products_others/" . $review->productOther->photos->first()['photo']) }}"> 
    </td> 
    <td>{{ $review->productOther->id }}</td> 
    <td>{{ $review->user->email }}</td> 
    <td>{{ $review->content }}</td>
    <td>{{ $review->rating }}</td>
    <td>{{ $review->productOther->name }}</td>
    <td>
        <a href="{{ route('show_review', ['review' => $review->id]) }}"><i class="c-brown-500 ti-star"></i></a>        
        <span data-url="reviews/delete/{{$review->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>