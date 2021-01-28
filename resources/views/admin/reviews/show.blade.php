@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h5 class="c-grey-900 mB-20">Продукт:</h5>
        <p>
            <strong>
                @if($review->product_id)
                    {{$review->product->name}}
                @elseif($review->model_id)
                    {{$review->model->name}}
                @elseif($review->product_others_id)
                    {{$review->productOther->name}}
                @endif
            </strong>
        </p>

        <h5 class="c-grey-900 mB-20">Заглавие:</h5>
        <p><strong>{{$review->title}}</strong></p>
        <h5 class="c-grey-900 mB-20">Потребител:</h5>
        <p><strong>{{ $review->user ? $review->user->name : "Анонимен"}}, {{$review->created_at}}</strong></p>
        <h5 class="c-grey-900 mB-20">Рейтинг:</h5>
        <p><strong>{{$review->rating}}</strong></p>
        <h5 class="c-grey-900 mB-20">Текст:</h5>
        <p><strong>{{$review->content}}</strong></p>
        <span data-url="reviews/delete/{{$review->id}}" class="delete-btn"><i class="c-brown-900 ti-trash"></i></span>
      </div>
    </div>
</div>
@endsection