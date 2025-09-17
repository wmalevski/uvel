<li class="element no_full_width"
		data-alpha="{{ $product->name }}" data-price="{{ $product->price }}" data-id="{{ $product->id }}">
	<ul class="row-container list-unstyled clearfix">
		<li class="row-left">
			<a href="{{ route('single_product_other', ['product' => $product->id])  }}" class="container_item">
				@php
					$gallery = App\Gallery::where('product_other_id', $product->id)->first();
					$hasImage = $gallery && $gallery->photo;
				@endphp
				@if($hasImage)
					<img src="{{ getPhoto('products_others/' . $gallery->photo) }}" class="img-responsive" alt="{{ $product->name }}">
				@else
					<div class="img-responsive" style="display: flex; align-items: center; justify-content: center; background-color: #f5f5f5; color: #666; text-align: center; padding: 20px; min-height: 100px;">
						Снимката не е налична
					</div>
				@endif
			</a>
			<div class="hbw">
				<span class="hoverBorderWrapper"></span>
			</div>
		</li>
		<li class="row-right parent-fly animMix">
			<div class="product-content-left">
				<a class="title-5" href="{{ route('single_product_other', ['product' => $product->id]) }}">
					Модел: {{ $product->name }}
				</a>
				<br/>
				No: {{ $product->id }}
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
						<i class="fa fa-lg fa-eye"></i>
						<span class="list-mode">Преглед</span>
					</a>

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
