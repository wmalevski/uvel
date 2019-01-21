<div class="quickview-modal-wrapper">
	<div class="modal-header">
		<i class="close fa fa-times btooltip" data-toggle="tooltip" data-placement="top" title="Затвори" data-dismiss="modal" aria-hidden="true"></i>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12 product-image">
				<div id="quick-shop-image" class="product-image-wrapper">

					<a class="main-image" href="{{ route('single_product', ['product' => $product->id])  }}">
						<img class="img-zoom img-responsive image-fly" alt="{{ $product->model->name }}"
							src="@if($product->photos){{ asset("uploads/products/" . $product->photos->first()['photo']) }}@endif"/>
					</a>

					<div id="gallery_main_qs" class="product-image-thumb">
						@if($product->photos)
							@foreach($product->photos as $image)
							<a class="image-thumb active" href="{{ asset("uploads/products/" . $image->photo) }}" data-image="{{ asset("uploads/products/" . $image->photo) }}"
							data-zoom-image="{{ asset("uploads/products/" . $image->photo) }}">
							<img src="{{ asset("uploads/products/" . $image->photo) }}" alt="{{ $product->model->name }}"/>
							</a>
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-12 product-information">
				<h1 id="quick-shop-title">
					<span>
						<a href="{{ route('single_product', ['product' => $product->id])  }}">
							{{ $product->name }}
						</a>
					</span>
				</h1>
				<div id="quick-shop-infomation" class="description">
					<div id="quick-shop-description" class="text-left">
						<p>
							No: {{ $product->code }}
							<br/>
							{{ $product->weight }}гр.
							<br/>
							Модел: {{ $product->model->name }}
							<br/>
							Бижу: {{ $product->jewel->name }}
							<br/>
							Размер: {{ $product->model->size }}
						</p>
					</div>
				</div>
				<div id="quick-shop-container">
					<div id="quick-shop-price-container" class="detail-price">
						<span class="price_sale">
							{{ $product->price }}лв.
						</span>
						<span class="dash"></span>
						{{-- <del class="price_compare">$300.00</del> --}}
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
