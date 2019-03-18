<li class="element @if($listType == 'goList') full_width @else no_full_width @endif"
    data-alpha="{{ $model->name }}" data-price="{{ $model->price }}" data-id="{{ $model->id }}">
    <ul class="row-container list-unstyled clearfix">
        <li class="row-left @if($listType == 'goList') col-md-8 @endif">
            <a href="{{ route('single_model', ['model' => $model->id])  }}" class="container_item">
                <img src="@if($model->photos) {{ asset("uploads/models/" . $model->photos->first()['photo']) }} @else {{ asset('store/images/demo_375x375.png') }} @endif"
                    class="img-fill" alt="{{ $model->name }}">
            </a>
            <div class="hbw hidden-xs hidden-sm ">
                <span class="hoverBorderWrapper"></span>
            </div>
        </li>
        <li class="row-right parent-fly animMix @if($listType == 'goList') col-md-16 @endif">
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
                        {{ number_format($model->price) }} лв
                    </span>
                </div>
            </div>

            <div class="hover-appear hidden-xs hidden-sm">
                <a href="{{ route('single_model', ['model' => $model->id]) }}" class="effect-ajax-cart product-ajax-qs" title="Преглед">
                    <input name="quantity" value="1" type="hidden">
                    <i class="fa fa-lg fa-th-list"></i>
                    <span class="list-mode">Преглед</span>
                </a>
                
                <button data-target="#quick-shop-modal" class="effect-ajax-cart quick_shop product-ajax-qs hidden-xs hidden-sm" data-toggle="modal"
                        data-url="models/{{ $model->id }}/" title="Бърз Преглед">
                    <i class="fa fa-lg fa-eye"></i>
                    <span class="list-mode">Бърз преглед</span>
                </button>
            </div>
            
        </li>
    </ul>
</li>
