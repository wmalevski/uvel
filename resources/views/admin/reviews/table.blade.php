<tr data-id="{{ $review->id }}">
    <td>
      @if($review->product_id)
        <img class="admin-product-image" src="{{ asset("uploads/products/" . $review->product->photos->first()['photo']) }}">
      @elseif($review->model_id)
        <img class="admin-product-image" src="{{ asset("uploads/models/" . $review->model->photos->first()['photo']) }}">
      @elseif($review->product_others_id)
        <img class="admin-product-image" src="{{ asset("uploads/products_others/" . $review->productOther->photos->first()['photo']) }}">
      @endif
    </td>
    <td>
      @if($review->product_id)
        {{ $review->product->id }}
      @elseif($review->model_id)
        {{ $review->model->id }}
      @elseif($review->product_others_id)
        {{ $review->productOther->id }}
      @endif
    </td> 
    <td>
      @if($review->product_id)
        Продукт
      @elseif($review->model_id)
        Модел
      @elseif($review->product_others_id)
        Кутии/Икони
      @endif
    </td> 
    <td>{{ $review->user->email }}</td> 
    <td>{{ $review->content }}</td>
    <td>{{ $review->rating }}</td>
    <td>
      @if($review->product_id)
        {{ $review->product->name }} [{{ $review->product->id }}]
      @elseif($review->model_id)
        {{ $review->model->name }}  [{{ $review->model->id }}]
      @elseif($review->product_others_id)
        {{ $review->productOther->name }} [{{ $review->productOther->id }}]
      @endif
    </td> 
    <td>
        <a href="{{ route('show_review', ['review' => $review->id]) }}"><i class="c-brown-500 ti-star"></i></a>        
        <span data-url="reviews/delete/{{$review->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>