<div class="quickview-modal-wrapper">
	<div class="modal-header">
		<i class="close fa fa-times btooltip" data-toggle="tooltip" data-placement="top" title="Затвори" data-dismiss="modal" aria-hidden="true"></i>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12 product-image">
				<div id="quick-shop-image" class="product-image-wrapper">

					<a class="main-image" href="{{ route('single_product', ['product' => $product->id])  }}">
						@php
							$hasProductPhoto = $product->photos && $product->photos->first() && isset($product->photos->first()['photo']);
							$hasModelPhoto = $product->model && $product->model->photos && $product->model->photos->first() && isset($product->model->photos->first()['photo']);
						@endphp
						@if($hasProductPhoto)
							<img class="img-zoom img-responsive image-fly" alt="{{ $product->model->name }}" src="{{ getPhoto('products/' . $product->photos->first()['photo']) }}">
						@elseif($hasModelPhoto)
							<img class="img-zoom img-responsive image-fly" alt="{{ $product->model->name }}" src="{{ getPhoto('models/' . $product->model->photos->first()['photo']) }}">
						@else
							<div class="img-zoom img-responsive image-fly" style="display: flex; align-items: center; justify-content: center; background-color: #f5f5f5; color: #666; text-align: center; padding: 40px; min-height: 200px;">
								Снимката не е налична
							</div>
						@endif
					</a>

					<div id="gallery_main_qs" class="product-image-thumb">
						@if($product->photos)
							@foreach($product->photos as $image)
							<a class="image-thumb active" href="{{ getPhoto("products/" . $image->photo) }}" data-image="{{ getPhoto("products/" . $image->photo) }}"
							data-zoom-image="{{ getPhoto("products/" . $image->photo) }}">
							<img src="{{ getPhoto("products/" . $image->photo) }}" alt="{{ $product->model->name }}"/>
							</a>
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-12 product-information">
				<h1 id="quick-shop-title">
					<span>
						<a href="{{ route('single_product', ['product' => $product->id])  }}">{{$product->id}}</a>
					</span>
				</h1>
				<div id="quick-shop-infomation" class="description">
					<div id="quick-shop-description" class="text-left">
						<p>
							No: {{ implode(" ", str_split($product->id, 3)) }}
							<br/>
							Модел: {{ $product->model->name }}
							<br/>
							{{ $product->material->name }} - {{ $product->material->code }} - {{ $product->material->color }}
							<br/>
							{{ $product->weight['weight'] }}гр.
							<br/>
							@if(isset($product->weight['stone']))
								@foreach($product->weight['stone'] as $productStone => $stone)
									{{ $stone}}
									@if(1 + $productStone < count($product->weight['stone'])) , @endif
								@endforeach
								<br>
							@endif
							Бижу: {{ $product->jewel->name }}
							<br/>
							Размер: {{ $product->size }}
							<br/>
							Налично в: {{ $product->store_info->name }}
						</p>
					</div>
				</div>
				<div id="quick-shop-container">
					<div id="quick-shop-price-container" class="detail-price">
						<span class="price_sale">
							{{ number_format($product->price) }} лв.
						</span>
						<span class="dash"></span>
					</div>
					<div class="others-bottom">
						<button id="quick-shop-add" class="btn small add-to-cart" type="submit" data-url="{{ route('CartAddItem', ['item' => $product->barcode, 'quantity' => 1]) }}">
							Добави в количката
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
