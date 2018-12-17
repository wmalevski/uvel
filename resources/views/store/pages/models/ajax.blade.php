<li class="element first no_full_width" data-alpha="{{ $model->name }}" data-price="{{ $model->price }}">
        <ul class="row-container list-unstyled clearfix">
            <li class="row-left">
            <a href="{{ route('single_model', ['model' => $model->id])  }}" class="container_item">
            <img src="@if($model->photos) {{ asset("uploads/models/" . $model->photos->first()['photo']) }} @else {{ asset('store/images/demo_375x375.png') }} @endif" class="img-responsive" alt="{{ $model->name }}">
            </a>
            <div class="hbw">
                <span class="hoverBorderWrapper"></span>
            </div>
            </li>
            <li class="row-right parent-fly animMix">
            <div class="product-content-left">
                <a class="title-5" href="{{ route('single_model', ['model' => $model->id])  }}">{{ $model->name }}</a>
                No: {{ $model->code }}<br/>
                {{ $model->weight }}гр.
                <span class="spr-badge" id="spr_badge_12932382113" data-rating="{{$model->getModelAvgRating($model)}}">
                @if(count($model->reviews) > 0)
                    <span class="spr-starrating spr-badge-starrating">
                        {{$model->listModelAvgRatingStars($model)}}
                    </span>
                @else
                    <span class="spr-badge-caption" style="display:block;">Няма ревюта</span>
                @endif
                </span>		
            </div>
            <div class="product-content-right">
                <div class="product-price">
                    <span class="price">{{ $model->price }} лв</span>
                </div>
            </div>
            
            <div class="hover-appear">
                <form action="#" method="post">
                    <div class="effect-ajax-cart">
                        <input name="quantity" value="1" type="hidden">
                        <button class="select-option" type="button" onclick="window.location.href='{{ route('single_model', ['model' => $model->id])  }}'"><i class="fa fa-th-list" title="Преглед"></i><span class="list-mode">Преглед</span></button>
                    </div>
                </form>
                <div class="product-ajax-qs hidden-xs hidden-sm">
                    <div data-handle="curabitur-cursus-dignis" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal" data-url="models/{{ $model->id }}/">
                        <i class="fa fa-eye" title="Бърз Преглед"></i><span class="list-mode">Бърз преглед</span>
                        
                    </div>
                </div>
            </div>
            </li>
        </ul>
    </li>