<li class="element no_full_width"
		data-alpha="{{ $product->name }}" data-price="{{ $product->price }}" data-id="{{$product->id}}">
	<ul class="row-container list-unstyled clearfix">
		<li class="row-left">
			<a href="{{ route('single_product', ['product' => $product->id]) }}" class="container_item">
				<img class="img-fill" alt="{{ $product->id }}" src="
				@if(count($product->photos))
				{{ asset("uploads/products/" . $product->photos->first()['photo']) }}
				@elseif(count($product->model->photos))
				{{ asset("uploads/models/" . $product->model->photos->first()['photo']) }}
				@else
				{{ asset('store/images/demo_375x375.png') }}
				@endif">
			</a>
			<div class="hbw">
				<span class="hoverBorderWrapper"></span>
			</div>
		</li>
		<li class="row-right parent-fly animMix">
			<div class="product-content-left">
				<a class="title-5" href="{{ route('single_product', ['product' => $product->id]) }}">No: {{$product->id}}</a>
				<br>
				Модел: {{ $product->model->name }}
				<br>
				{{ $product->material->name }} - {{ $product->material->code }} - {{ $product->material->color }}
				<br>
				{{ $product->weight['weight'] }}гр.
				<br>
				@if(isset($product->weight['stone']))
					@foreach($product->weight['stone'] as $productStone => $stone)
						{{ $stone}}
						@if(1 + $productStone < count($product->weight['stone'])) , @endif
					@endforeach
					<br>
				@endif
				Налично в: {{ $product->store_info->name }}
				<span class="spr-badge" data-rating="0.0">
				<span class="spr-starrating spr-badge-starrating">{!! $product->listProductAvgRatingStars($product) !!}</span>
			</span>
			</div>
			<div class="product-content-right">
				<div class="product-price">
					<span class="price">{{ number_format($product->price) }} лв.</span>
				</div>
			</div>

			<div class="hover-appear">
				<a href="{{ route('single_product', ['product' => $product->id]) }}" class="effect-ajax-cart product-ajax-qs" title="Преглед">
					<input name="quantity" value="1" type="hidden">
					<i class="fa fa-lg fa-eye"></i>
					<span class="list-mode">Преглед</span>
				</a>

				@if (Auth::user() !== NULL)
				<button class="wish-list" title="Добави в желани"
								data-url="{{ route('wishlists_store', ['type' => 'product', 'item' => $product->id]) }}">
					<i class="fa fa-lg fa-heart"></i>
					<span class="list-mode">Добави в желани</span>
				</button>
				@endif
			</div>

		</li>
	</ul>
</li>
