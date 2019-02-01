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
				<a class="title-5" href="{{ route('single_product', ['product' => $product->id])  }}">
					{{ $product->name }}
				</a>
				<br/>
				No: {{ $product->code }}
				<br/>
				<span class="spr-starrating spr-badge-starrating">
					{{$product->listProductOtherAvgRatingStars($product)}}
				</span>
			</div>
			<div class="product-content-right">
				<div class="product-price">
					<span class="price">
						{{ $product->price }} лв
					</span>
				</div>
			</div>
			<div class="hover-appear">
				<div class="effect-ajax-cart">
					<input name="quantity" value="1" type="hidden">
					<button href="{{ route('single_product', ['product' => $product->id]) }}">
						<i class="fa fa-th-list" title="Преглед"></i>
						<span class="list-mode">Преглед</span>
					</button>
				</div>
				<div class="product-ajax-qs hidden-xs hidden-sm">
					<div data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal" data-barcode="{{ $product->barcode }}">
						<i class="fa fa-eye" title="Бърз Преглед"></i>
						<span class="list-mode">
							Бърз преглед
						</span>
					</div>
				</div>
				<a class="wish-list" data-url="{{ route('wishlists_store', ['type' => 'product', 'item' => $product->id]) }}" href="#" title="Наблюдавани">
				 <i class="fa fa-heart"></i>
				 	<span class="list-mode">
						Добави в желани
					</span>
				</a>
			</div>
		</li>
	</ul>
</li>
