<li class="element @if($listType == 'goList') full_width @else no_full_width @endif"
		data-alpha="{{ $product->name }}" data-price="{{ $product->price }}" data-id="{{ $product->id }}">
	<ul class="row-container list-unstyled clearfix">
		<li class="row-left @if($listType == 'goList') col-md-8 @endif">
			<a href="{{ route('single_product_other', ['product' => $product->id])  }}" class="container_item">
				<img src="@if(App\Gallery::where('product_other_id',$product->id)->get()) {{ asset("uploads/products_others/" . App\Gallery::where('product_other_id', $product->id)->first()->photo) }} @else {{ asset('store/images/demo_375x375.png') }} @endif"
					 class="img-responsive" alt="{{ $product->name }}">
			</a>
			<div class="hbw">
				<span class="hoverBorderWrapper"></span>
			</div>
		</li>
		<li class="row-right parent-fly animMix @if($listType == 'goList') col-md-16 @endif">
			<div class="product-content-left">
				<a class="title-5" href="{{ route('single_product_other', ['product' => $product->id]) }}">
					Модел: {{ $product->name }}
				</a>
				<br/>
				No: {{ $product->code }}
				<br/>
				Налично в: {{ App\Store::where('id',$product->store_id)->first()->name }}
				<br/>
				<br/>
				<span class="spr-badge">
					<span class="spr-starrating spr-badge-starrating">
						{{$product->listProductOtherAvgRatingStars($product)}}
					</span>
				</span>
			</div>
			<div class="product-content-right">
				<div class="product-price">
					<span class="price">
						{{ number_format($product->price) }} лв.
					</span>
				</div>
			</div>
			
			<div class="hover-appear">
				<div class="hover-appear">
					<a href="{{ route('single_product_other', ['products' => $product->id]) }}" class="effect-ajax-cart product-ajax-qs" title="Преглед">
						<input name="quantity" value="1" type="hidden">
						<i class="fa fa-lg fa-th-list"></i>
						<span class="list-mode">Преглед</span>
					</a>

					<button data-target="#quick-shop-modal" class="quick_shop product-ajax-qs hidden-xs hidden-sm" data-toggle="modal"
							data-url="productsothers/{{ $product->id }}/" title="Бърз Преглед">
						<i class="fa fa-lg fa-eye"></i>
						<span class="list-mode">Бърз преглед</span>
					</button>

					<button class="wish-list" title="Добави в желани"
							data-url="{{ route('wishlists_store', ['type' => 'product_other', 'item' => $product->id]) }}">
						<i class="fa fa-lg fa-heart"></i>
						<span class="list-mode">Добави в желани</span>
					</button>
				</div>
			</div>
		</li>
	</ul>
</li>
