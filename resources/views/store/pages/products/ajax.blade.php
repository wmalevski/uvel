<li class="element first @if($listType == 'goList') full_width @else no_full_width @endif" data-alpha="{{ $product->name }}"
 data-price="{{ $product->price }}">
	<ul class="row-container list-unstyled clearfix">
		<li class="row-left @if($listType == 'goList') col-md-8 @endif">
			<a href="{{ route('single_product', ['product' => $product->id])  }}" class="container_item">
				<img class="img-fill" alt="{{ $product->name }}"
				 src="@if($product->photos) {{ asset("uploads/products/" . $product->photos->first()['photo']) }} @else {{ asset('store/images/demo_375x375.png') }} @endif">
			</a>
			<div class="hbw">
				<span class="hoverBorderWrapper"></span>
			</div>
		</li>
		<li class="row-right parent-fly animMix @if($listType == 'goList') col-md-16 @endif">
			<div class="product-content-left">
				<a class="title-5" href="{{ route('single_product', ['product' => $product->id])  }}">{{ $product->name }}</a>
				No: {{ $product->code }}
				<br />
				{{ $product->weight }}гр.
				<span class="spr-badge" data-rating="{{$product->getProductAvgRating($product)}}">
					<span class="spr-starrating spr-badge-starrating">
						{{$product->listproductAvgRatingStars($product)}}
					</span>
				</span>
			</div>
			<div class="product-content-right">
				<div class="product-price">
					<span class="price">{{ $product->price }} лв</span>
				</div>
			</div>

			<div class="hover-appear">
				<a href="{{ route('single_product', ['product' => $product->id]) }}" class="effect-ajax-cart product-ajax-qs" title="Преглед">
					<input name="quantity" value="1" type="hidden">
					<i class="fa fa-th-list"></i>
					<span class="list-mode">Преглед</span>
				</a>
				
				<a href="#" data-target="#quick-shop-modal" class="quick_shop product-ajax-qs hidden-xs hidden-sm" data-toggle="modal"
					 data-url="products/{{ $product->id }}/">
					<i class="fa fa-eye" title="Бърз Преглед"></i>
					<span class="list-mode">Бърз преглед</span>
				</a>
				
				<a href="#" class="wish-list" title="Добави в желани"
					 data-url="{{ route('wishlists_store', ['type' => 'product', 'item' => $product->id]) }}">
					<i class="fa fa-heart"></i>
					<span class="list-mode">Добави в желани</span>
				</a>
			</div>
			
		</li>
	</ul>
</li>
