<tr data-id="{{ $review->id }}">
    <td>
      @if($review->product_id)
        @php
          $hasProductPhoto = $review->product && $review->product->photos && $review->product->photos->first() && isset($review->product->photos->first()['photo']);
        @endphp
        @if($hasProductPhoto)
          <img class="admin-product-image" src="{{ getPhoto('products/' . $review->product->photos->first()['photo']) }}">
        @else
          <span style="color: #666;">Няма снимка</span>
        @endif
      @elseif($review->model_id)
        @php
          $hasModelPhoto = $review->model && $review->model->photos && $review->model->photos->first() && isset($review->model->photos->first()['photo']);
        @endphp
        @if($hasModelPhoto)
          <img class="admin-product-image" src="{{ getPhoto('models/' . $review->model->photos->first()['photo']) }}">
        @else
          <span style="color: #666;">Няма снимка</span>
        @endif
      @elseif($review->product_others_id)
        @php
          $hasOtherPhoto = $review->productOther && $review->productOther->photos && $review->productOther->photos->first() && isset($review->productOther->photos->first()['photo']);
        @endphp
        @if($hasOtherPhoto)
          <img class="admin-product-image" src="{{ getPhoto('products_others/' . $review->productOther->photos->first()['photo']) }}">
        @else
          <span style="color: #666;">Няма снимка</span>
        @endif
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
    <td>{{ $review->user ? $review->user->email : "Анонимен"}}</td>
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