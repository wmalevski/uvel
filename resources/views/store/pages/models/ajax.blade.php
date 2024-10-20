<li class="element no_full_width"
    data-alpha="{{ $model->name }}" data-price="{{ $model->price }}" data-id="{{ $model->id }}">
    <ul class="row-container list-unstyled clearfix">
        <li class="row-left>
            <a href="{{ route('single_model', ['model' => $model->id])  }}" class="container_item">
                <img src="@if($model->photos) {{ asset("uploads/models/" . $model->photos->first()['photo']) }} @else {{ asset('store/images/demo_375x375.png') }} @endif"
                    class="img-fill" alt="{{ $model->name }}">
            </a>
            <div class="hbw hidden-xs hidden-sm ">
                <span class="hoverBorderWrapper"></span>
            </div>
        </li>
        <li class="row-right parent-fly animMix">
            <div class="product-content-left">
                <a class="title-5" href="{{ route('single_model', ['model' => $model->id])  }}">
                {{ $model->name }}
                </a>
                <br/>
                {{ $model->weight }}гр.
                <br>
                <strong class="text-danger">По Поръчка за 10 дни</strong>
                <span class="spr-badge" data-rating="{{$model->getModelAvgRating($model)}}">
                    <span class="spr-starrating spr-badge-starrating">
                        {{$model->listModelAvgRatingStars($model)}}
                    </span>
                </span>
            </div>

            <div class="product-content-right">
                <div class="product-price">
                    <span class="price">
                        {{ number_format($model->price) }} лв.
                    </span>
                </div>
            </div>

            <div class="hover-appear hidden-xs hidden-sm">
                <a href="{{ route('single_model', ['model' => $model->id]) }}" class="effect-ajax-cart product-ajax-qs" title="Преглед">
                    <input name="quantity" value="1" type="hidden">
                    <i class="fa fa-lg fa-eye"></i>
                    <span class="list-mode">Преглед</span>
                </a>
            </div>

        </li>
    </ul>
</li>
