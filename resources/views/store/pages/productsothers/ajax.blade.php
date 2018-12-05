<li class="element first no_full_width" data-alpha="{{ $product->name }}" data-price="{{ $product->price }}">
        <ul class="row-container list-unstyled clearfix">
            <li class="row-left">
            <a href="{{ route('single_product', ['product' => $product->id])  }}" class="container_item">
            <img src="@if($product->photos) {{ asset("uploads/products/" . $product->photos->first()['photo']) }} @else {{ asset('store/images/demo_375x375.png') }} @endif" class="img-responsive" alt="{{ $product->name }}">
            </a>
            <div class="hbw">
                <span class="hoverBorderWrapper"></span>
            </div>
            </li>
            <li class="row-right parent-fly animMix">
            <div class="product-content-left">
                <a class="title-5" href="{{ route('single_product', ['product' => $product->id])  }}">{{ $product->name }}</a>
                <span class="spr-badge" id="spr_badge_12932382113" data-rating="0.0">
                <span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i></span>
                <span class="spr-badge-caption">
                No reviews </span>
                </span>
            </div>
            <div class="product-content-right">
                <div class="product-price">
                    <span class="price">{{ $product->price }} лв</span>
                </div>
            </div>
            <div class="list-mode-description">
                 {{-- Модел: {{ $product->model->name }} <br/>
                 Бижу: {{ $product->jewel->name }} <br/>
                 Размер: {{ $product->model->size }} --}}
            </div>
            <div class="hover-appear">
                <form action="#" method="post">
                    <div class="effect-ajax-cart">
                        <input name="quantity" value="1" type="hidden">
                        <button class="select-option" type="button" onclick="window.location.href='{{ route('single_product', ['product' => $product->id])  }}'"><i class="fa fa-th-list" title="Select Options"></i><span class="list-mode">Преглед</span></button>
                    </div>
                </form>
                <div class="product-ajax-qs hidden-xs hidden-sm">
                    <div data-handle="curabitur-cursus-dignis" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal" data-barcode="{{ $product->barcode }}">
                        <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Бърз преглед</span>
                        
                    </div>
                </div>
                <a class="wish-list" data-url="{{ route('wishlists_store', ['type' => 'product', 'item' => $product->id]) }}" href="#" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Добави в желани</span></a>
            </div>
            </li>
        </ul>
    </li>