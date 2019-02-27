<li class="element first @if($listType == 'goList') full_width @else no_full_width @endif" data-alpha="{{ $model->name }}"
    data-price="{{ $model->price }}">
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
                No: {{ $model->code }}
                <br />
                {{ $model->weight }}гр.
                <span class="spr-badge" data-rating="{{$model->getModelAvgRating($model)}}">
                    <span class="spr-starrating spr-badge-starrating">
                        {{$model->listModelAvgRatingStars($model)}}
                    </span>
                </span>
            </div>
            <div class="product-content-right">
                <div class="product-price">
                    <span class="price">
                        {{ $model->price }} лв
                    </span>
                </div>
            </div>

            <div class="hover-appear hidden-xs hidden-sm">
                <a href="{{ route('single_model', ['model' => $model->id]) }}" class="effect-ajax-cart product-ajax-qs" title="Преглед">
                    <input name="quantity" value="1" type="hidden">
                    <i class="fa fa-lg fa-th-list"></i>
                    <span class="list-mode">Преглед</span>
                </a>
                
                <div data-target="#quick-shop-modal" class="quick_shop product-ajax-qs hidden-xs hidden-sm" data-toggle="modal"
                     data-url="models/{{ $model->id }}/" title="Бърз Преглед">
                    <i class="fa fa-lg fa-eye"></i>
                    <span class="list-mode">Бърз преглед</span>
                </div>
            </div>
            
        </li>
    </ul>
</li>
